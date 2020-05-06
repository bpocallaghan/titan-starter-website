<?php

namespace App\Http\Controllers\Admin\FAQ;

use App\Http\Controllers\Admin\AdminController;
use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\View\View;
use Illuminate\Routing\Redirector;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;

class FAQsController extends AdminController
{
    /**
     * Display a listing of faq.
     *
     * @return Factory|View
     */
    public function index()
    {
        save_resource_url();
        $items = FAQ::with('category')->get();

        return $this->view('faqs.index')->with('items', $items);
    }

    /**
     * Show the form for creating a new faq.
     *
     * @return Factory|View
     */
    public function create()
    {
        $categories = FAQCategory::getAllList();

        return $this->view('faqs.create_edit')->with('categories', $categories);
    }

    /**
     * Store a newly created faq in storage.
     *
     * @return RedirectResponse|Redirector
     */
    public function store()
    {
        $attributes = request()->validate(FAQ::$rules, FAQ::$messages);

        $faq = $this->createEntry(FAQ::class, $attributes);

        return redirect_to_resource();
    }

    /**
     * Display the specified faq.
     *
     * @param FAQ $faq
     * @return Factory|View
     */
    public function show(FAQ $faq)
    {
        return $this->view('faqs.show')->with('item', $faq);
    }

    /**
     * Show the form for editing the specified faq.
     *
     * @param FAQ $faq
     * @return Factory|View
     */
    public function edit(FAQ $faq)
    {
        $categories = FAQCategory::getAllList();

        return $this->view('faqs.create_edit')
            ->with('item', $faq)
            ->with('categories', $categories);
    }

    /**
     * Update the specified faq in storage.
     *
     * @param FAQ $faq
     * @return RedirectResponse|Redirector
     */
    public function update(FAQ $faq)
    {
        $attributes = request()->validate(FAQ::$rules, FAQ::$messages);

        $faq = $this->updateEntry($faq, $attributes);

        return redirect_to_resource();
    }

    /**
     * Remove the specified faq from storage.
     *
     * @param FAQ $faq
     * @return RedirectResponse|Redirector
     */
    public function destroy(FAQ $faq)
    {
        $this->deleteEntry($faq, request());

        return redirect_to_resource();
    }
}
