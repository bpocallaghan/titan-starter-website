<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Models\Page;
use App\Models\Banner;
use Illuminate\View\View;
use Illuminate\Support\Arr;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Traits\UploadImageHelper;

class BannersController extends AdminController
{
    use UploadImageHelper;

    /**
     * Display a listing of banner.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('banners.index')->with('items', Banner::all());
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return Factory|View
     */
    public function create()
    {
        $pages = Page::getAllList();

        return $this->view('banners.create_edit')->with('pages', $pages);
    }

    /**
     * Store a newly created banner in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(Banner::$rules, Banner::$messages);

        $attributes['hide_name'] = (bool) input('hide_name');
        $attributes['is_website'] = (bool) input('is_website');

        $photo = $this->uploadImage($attributes['photo'], Banner::$IMAGE_SIZE);
        if ($photo) {
            $attributes['image'] = $photo;
            unset($attributes['photo']);
            $banner = $this->createEntry(Banner::class, $attributes);
            $banner->pages()->sync(input('pages'));


        }

        return redirect_to_resource();
    }

    /**
     * Display the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function show(Banner $banner)
    {
        return $this->view('banners.show')->with('item', $banner);
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param Banner $banner
     * @return Factory|View
     */
    public function edit(Banner $banner)
    {
        $pages = Page::getAllList();
        return $this->view('banners.create_edit')->with('pages', $pages)->with('item', $banner);
    }

    /**
     * Update the specified banner in storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function update(Banner $banner)
    {
        if (request()->file('photo') === null) {
            $attributes = request()->validate(
                Arr::except(Banner::$rules, 'photo'),
                Banner::$messages
            );
        } else {
            $attributes = request()->validate(Banner::$rules, Banner::$messages);

            $photo = $this->uploadImage($attributes['photo'], Banner::$IMAGE_SIZE);
            if ($photo) {
                $attributes['image'] = $photo;
            }
        }

        unset($attributes['photo']);
        $attributes['hide_name'] = (bool) input('hide_name');
        $attributes['is_website'] = (bool) input('is_website');

        $banner = $this->updateEntry($banner, $attributes);
        $banner->pages()->sync(input('pages'));

        return redirect_to_resource();
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param Banner $banner
     * @return RedirectResponse|Redirector
     */
    public function destroy(Banner $banner)
    {
        $this->deleteEntry($banner, request());

        return redirect_to_resource();
    }
}
