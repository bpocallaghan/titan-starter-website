<?php

namespace App\Http\Controllers\Admin\Banners;

use App\Models\Banner;
use App\Http\Controllers\Admin\AdminController;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;

class BannersController extends AdminController
{
    /**
     * Display a listing of banner.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        save_resource_url();

        return $this->view('banners.index')->with('items', Banner::all());
    }

    /**
     * Show the form for creating a new banner.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return $this->view('banners.create_edit');
    }

    /**
     * Store a newly created banner in storage.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function store()
    {
        $attributes = request()->validate(Banner::$rules, Banner::$messages);

        $attributes['hide_name'] = (bool) input('hide_name');
        $attributes['is_website'] = (bool) input('is_website');

        $photo = $this->uploadBanner($attributes['photo']);
        if ($photo) {
            $attributes['image'] = $photo;
            unset($attributes['photo']);
            $banner = $this->createEntry(Banner::class, $attributes);
        }

        return redirect_to_resource();
    }

    /**
     * Display the specified banner.
     *
     * @param Banner $banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Banner $banner)
    {
        return $this->view('banners.show')->with('item', $banner);
    }

    /**
     * Show the form for editing the specified banner.
     *
     * @param Banner $banner
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Banner $banner)
    {
        return $this->view('banners.create_edit')->with('item', $banner);
    }

    /**
     * Update the specified banner in storage.
     *
     * @param Banner $banner
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Banner $banner)
    {
        if (request()->file('photo') === null) {
            $attributes = request()->validate(Arr::except(Banner::$rules, 'photo'),
                Banner::$messages);
        }
        else {
            $attributes = request()->validate(Banner::$rules, Banner::$messages);

            $photo = $this->uploadBanner($attributes['photo']);
            if ($photo) {
                $attributes['image'] = $photo;
            }
        }

        unset($attributes['photo']);
        $attributes['hide_name'] = (bool) input('hide_name');
        $attributes['is_website'] = (bool) input('is_website');

        $this->updateEntry($banner, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified banner from storage.
     *
     * @param Banner $banner
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function destroy(Banner $banner)
    {
        $this->deleteEntry($banner, request());

        return redirect_to_resource();
    }

    /**
     * Upload the banner image, create a thumb as well
     *
     * @param        $file
     * @param string $path
     * @param array  $size
     * @return string|void
     */
    private function uploadBanner(
        UploadedFile $file, $path = '', $size = ['o' => [1920, 1000], 'tn' => [960, 500]]
    ) {
        $name = token();
        $extension = $file->guessClientExtension();

        $filename = $name . '.' . $extension;
        $filenameThumb = $name . '-tn.' . $extension;
        $imageTmp = Image::make($file->getRealPath());

        if (!$imageTmp) {
            return notify()->error('Oops', 'Something went wrong', 'warning shake animated');
        }

        $path = upload_path_images($path);

        // original
        $imageTmp->save($path . $name . '-o.' . $extension);

        // save the image
        $image = $imageTmp->fit($size['o'][0], $size['o'][1])->save($path . $filename);

        $image->fit($size['tn'][0], $size['tn'][1])->save($path . $filenameThumb);

        return $filename;
    }
}
