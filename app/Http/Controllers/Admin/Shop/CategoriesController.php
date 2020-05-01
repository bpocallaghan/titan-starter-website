<?php

namespace App\Http\Controllers\Admin\Shop;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Intervention\Image\Facades\Image;
use Redirect;
use App\Http\Requests;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class CategoriesController extends AdminController
{
    /**
     * Display a listing of product_category.
     *
     * @return Response
     */
    public function index()
    {
        save_resource_url();

        $items = ProductCategory::with('parent')->get();

        return $this->view('shop.categories.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new product_category.
     *
     * @return Response
     */
    public function create()
    {
        $parents = ProductCategory::getAllList();

        return $this->view('shop.categories.create_edit')->with('parents', $parents);
    }

    /**
     * Store a newly created product_category in storage.
     *
     * @return Response
     */
    public function store()
    {
        $attributes = request()->validate(ProductCategory::$rules, ProductCategory::$messages);

        $photo = $this->uploadImage($attributes['photo']);
        if ($photo) {
            $attributes['image'] = $photo;
            unset($attributes['photo']);

            $category = $this->createEntry(ProductCategory::class, $attributes);

            $category->updateUrl()->save();
        }

        return redirect_to_resource();
    }

    /**
     * Display the specified product_category.
     *
     * @param ProductCategory $category
     * @return Response
     */
    public function show(ProductCategory $category)
    {
        return $this->view('shop.categories.show')->with('item', $category);
    }

    /**
     * Show the form for editing the specified product_category.
     *
     * @param ProductCategory $category
     * @return Response
     */
    public function edit(ProductCategory $category)
    {
        $parents = ProductCategory::getAllList();

        return $this->view('shop.categories.create_edit')
            ->with('item', $category)
            ->with('parents', $parents);
    }

    /**
     * Update the specified product_category in storage.
     *
     * @param ProductCategory $category
     * @return Response
     */
    public function update(ProductCategory $category)
    {

        //dd(request()->file('photo'));

        if (request()->file('photo') === null) {
            $attributes = request()->validate(Arr::except(ProductCategory::$rules, 'photo'),
                ProductCategory::$messages);
        }
        else {
            $attributes = request()->validate(ProductCategory::$rules, ProductCategory::$messages);

            $photo = $this->uploadImage($attributes['photo']);
            if ($photo) {
                $attributes['image'] = $photo;
            }
        }

        unset($attributes['photo']);

        $category = $this->updateEntry($category, $attributes);
        $category->updateUrl()->save();

        return redirect_to_resource();
    }

    /**
     * Remove the specified product_category from storage.
     *
     * @param ProductCategory $category
     * @return Response
     */
    public function destroy(ProductCategory $category)
    {
        $this->deleteEntry($category, request());

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
    private function uploadImage(
        UploadedFile $file, $path = '', $size = ['o' => [1024, 1024], 'tn' => [255, 255]]
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
