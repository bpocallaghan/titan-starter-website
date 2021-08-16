<?php

namespace App\Http\Controllers\Admin\Resources;

use App\Models\Section;
use App\Models\Content;
use App\Models\Navigation;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Traits\ImageThumb;
use Intervention\Image\Facades\Image;
use App\Http\Controllers\Admin\AdminController;

class ContentController extends AdminController
{
    /**
     * Display a listing of content.
     * @param  $resourceable
     * @param  $id
     * @param Section $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index($resourceable, $id, Section $section)
    {
        save_resource_url();

        $section->load('sections');

        return $this->view('resources.sections.components.section_components')->with('section', $section);
    }

    /**
     * Display a listing of content.
     * @param  $resourceable
     * @param  $id
     * @param Section $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show()
    {
        return $this->view('resources.sections.components.index')->with('items', Content::with('sections')->get());
    }

    /**
     * Show the form for creating a new content.
     * @param  $resourceable
     * @param  $id
     * @param Section $section
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($resourceable, $id, Section $section)
    {
        $resource = Str::plural($resourceable, 1);
        $resourceable = Str::singular($resourceable, 1);

        $model_name = str_replace('-', ' ',ucwords($resourceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        $back = url()->previous();

        return $this->view('resources.sections.components.content')->with('section', $section)->with('resource', $resourceable)->with('resourceable', $model)->with('back', $back);
    }

    /**
     * Store a newly created article in storage.
     * @param  $resourceable
     * @param  $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store($resourceable, $id, Section $section, Request $request)
    {
        $resource = Str::plural($resourceable);

        if (request()->file('media') === null) {
            $attributes = request()->validate(Arr::except(Content::$rules, 'media'),
                Content::$messages);
        }
        else {
            $attributes = request()->validate(Content::$rules, Content::$messages);

            $media = $this->moveAndCreatePhoto($attributes['media'], $size = ['l' => Content::$LARGE_SIZE, 's' => Content::$THUMB_SIZE]);
            if ($media) {
                $attributes['media'] = $media;
            }
        }

        $sectionContent = $this->createEntry(Content::class, $attributes);
        $sectionContent->sections()->syncWithoutDetaching([$section->id]);

        return redirect('admin/'.$resource.'/' . $id . '/sections/'.$request->section_id.'/content/' . $sectionContent->id . '/edit');
    }

    /**
     * Show the form for editing the specified content.
     * @param  $resourceable
     * @param  $id
     * @param Section  $section
     * @param Content $content
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($resourceable, $id, Section $section, Content $content)
    {
        $resource = Str::plural($resourceable);
        $resourceable = Str::singular($resourceable, 1);

        $model_name = str_replace('-', ' ',ucwords($resourceable));
        $model_name = str_replace(' ', '',ucwords($model_name));

        $resource_type = 'App\Models\\'.$model_name;
        $model = app($resource_type);
        $model = $model->find($id);

        $navigationUrl = Navigation::where('slug', $resource)->first();
        $back = $navigationUrl->url.'/'. $id .'/edit';

        return $this->view('resources.sections.components.content')->with('section', $section)->with('item', $content)->with('resource', $resource)->with('resourceable', $model)->with('back', $back);
    }

    /**
     * Update the specified content in storage.
     * @param  $resourceable
     * @param  $id
     * @param Section $section
     * @param Content $content
     * @return Response
     */
    public function update($resourceable, $id, Section $section, Content $content)
    {
        $resource = Str::plural($resourceable);

        if (is_null(request()->file('media'))) {
            $attributes = request()->validate(Arr::except(Content::$rules, 'media'),
                Content::$messages);
        }
        else {
            $attributes = request()->validate(Content::$rules, Content::$messages);

            $media = $this->moveAndCreatePhoto($attributes['media'], $size = ['l' => Content::$LARGE_SIZE, 's' => Content::$THUMB_SIZE]);
            if ($media) {
                $attributes['media'] = $media;
            }
        }

        $item = $this->updateEntry($content, $attributes);

        $item->sections()->syncWithoutDetaching([$section->id]);

        return redirect('admin/'.$resource.'/' . $id . '/sections/'.$section->id.'/content/' . $content->id . '/edit');
    }

    /**
     * Remove the specified content from storage.
     * @param  $resourceable
     * @param  $id
     * @param Section $section
     * @param Content $content
     * @return Response
     */
    public function destroy($resourceable, $id, Section $section, Content $content)
    {

        if($content->sections->count() > 1 ){
            foreach($content->sections as $section){
                $section->components()->detach([$content->id]);
            }
        }else {
            $section->components()->detach([$content->id]);
        }

        // delete Section_content
        $this->deleteEntry($content, request());

        log_activity(' Component Deleted',
            'A Section Content was successfully removed from the Sections', $content);

        return redirect_to_resource();
    }

    /**
     * Remove the specified content from storage.

     * @param Content $content
     * @return Response
     */
    public function destroyContent(Content $content)
    {
        if($content->sections->count() > 1 ){
            foreach($content->sections as $section){
                $section->components()->detach([$content->id]);
            }
        }

        // delete Section_content
        $this->deleteEntry($content, request());

        log_activity(' Component Deleted',
            'A Content was successfully removed', $content);

        return redirect_to_resource();
    }

    /**
     * Remove the specified content from storage.
     * @param  $resourceable
     * @param  $id
     * @param Section $sec
     * @param Section $section
     * @param Content $content
     * @return Response
     */
    public function remove($resourceable, $id, Section $section, Content $content)
    {

        $section->components()->detach([$content->id]);

        log_activity(' Component Removed',
            'A Section Content was successfully removed from the Sections', $content);

        return redirect()->back();
    }

    /**
     * @param  $resourceable
     * @param  $id
     * @param Content $content
     * @return array
     */
    public function updateOrder($resourceable, $id, Content $content)
    {
        $items = json_decode(request('list'), true);

        foreach ($items as $key => $item) {

            $row = Content::find($item['id']);
            if ($row) {
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
     * @param Section        $section
     * @param Content $content
     * @return array
     */
    public function removeMedia($resourceable, $id ,Section $section, Content $content)
    {
        $content->media = null;
        $content->save();

        return ['result' => 'success'];
    }

    /**
     * Save Image in Storage, crop image and save in public/uploads/images
     * @param UploadedFile $file
     * @param array        $size
     * @return SectionContentController|bool|\Illuminate\Http\JsonResponse
     */
    private function moveAndCreatePhoto(
        UploadedFile $file, $size = ['l' => [1024, 768], 's' => [320, 240]]
    ) {
        $extension = '.' . $file->extension();

        $name = token();
        $filename = $name . $extension;

        $path = upload_path_images();
        $imageTmp = Image::make($file->getRealPath());

        if (!$imageTmp) {
            return false;
        }

        $largeSize = $size['l'];
        $thumbSize = $size['s'];

        // save original
        $imageTmp->save($path . $name . ImageThumb::$originalAppend . $extension);

        // if height is the biggest - resize on max height
        if ($imageTmp->width() < $imageTmp->height()) {
            // resize the image to the large height and constrain aspect ratio (auto width)
            $imageTmp->resize(null, $largeSize[1], function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            // resize the image to the thumb height and constrain aspect ratio (auto width)
            $imageTmp->resize(null, $thumbSize[1], function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $name . ImageThumb::$thumbAppend . $extension);
        }
        else {
            // resize the image to the large width and constrain aspect ratio (auto height)
            $imageTmp->resize($largeSize[0], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $filename);

            // resize the image to the thumb width and constrain aspect ratio (auto width)
            $imageTmp->resize($thumbSize[0], null, function ($constraint) {
                $constraint->aspectRatio();
            })->save($path . $name . ImageThumb::$thumbAppend . $extension);
        }

        return $filename;
    }
}
