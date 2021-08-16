<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Http\Requests;
use App\Models\Content;
use App\Models\Section;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class SectionsController extends AdminController
{

    /**
     * Display a listing of content.
     *
     * @param $resourceable
     * @param $id
     * @return Response
     */
    public function index($resourceable, $id)
    {
        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable, 1);

        $model_name = str_replace('-', ' ',ucwords($resourceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        save_resource_url();

        // get list of content
        $content = Content::getAllList();

        $model->load('sections.components');

        return $this->view('resources.sections.section_components')
        ->with('content', $content)
        ->with('resourceable', $model)
        ->with('resource', $resource);
    }

    /**
     * Show the form for creating a new content.
     *
     * @param $resouceable
     * @param $id
     * @return Response
     */
    public function create($resourceable, $id)
    {
        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable, 1);

        $model_name = str_replace('-', ' ',ucwords($resourceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        $content = Content::getAllList();

        $back = url()->previous();

        return $this->view('resources.sections.create_edit')->with('resourceable', $model)->with('resource', $resource)->with('content', $content)->with('back', $back);
    }

    /**
     * Store a newly created section in storage.
     *
     * @param Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $attributes = request()->validate(Section::$rules);

        $Section = $this->createEntry(Section::class, $attributes);

        return redirect_to_resource();
        //return redirect()->back();
    }

    /**
     * Update the specified content in storage.
     *
     ** @param $resourceable
     * @param $id
     * @param Section     $section
     * @return Response
     */
    public function update($resourceable, $id, Section $section)
    {

        $attributes = request()->validate(Section::$rules, Section::$messages);
        $section = $this->updateEntry($section, $attributes);

        return redirect()->back();
    }

    /**
     * Remove the specified content from storage.
     *
     * @param $resourceable
     * @param $id
     * @param Section $section
     * @return Response
     * @internal param $camp_section
     */
    public function destroy($resourceable, $id, Section $section)
    {
        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable, 1);

        if($section->components !== ''){
            foreach ($section->components as $components){
                Content::find($components->id)->delete();
            }

        }
        // delete Camp_sections
        $this->deleteEntry($section, request());

        log_activity('Section Deleted', 'A Section was successfully removed from the '.$resourceable, $section);

        return redirect_to_resource();
    }

    /**
     * @return array
     */
    public function updateOrder()
    {

        $items = json_decode(request('list'), true);

        foreach ($items as $key => $item) {

            $row = Section::find($item['id']);
            if($row) {
                $row->update([
                    'list_order' => ($key + 1)
                ]);
            }
        }

        return ['result' => 'success'];
    }

    /**
     * @param  $resourceable
     * @param  $id
     * @param Section  $section
     * @return array
     */
    public function attach($resourceable, $id, Section $section)
    {
        $section->components()->syncWithoutDetaching([input('content_id')]);

        return redirect()->back();
    }
}
