<?php

namespace App\Http\Controllers\Client;

use App\Models\FAQ;
use Illuminate\View\View;
use App\Models\FAQCategory;
use Illuminate\Contracts\View\Factory;
use App\Http\Controllers\Website\WebsiteController;

class FAQController extends WebsiteController
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $categories = FAQCategory::getAllList();
        $items = FAQCategory::with('faqs')->orderBy('name')->get();

        return $this->view('audit_quickies.index', compact('items', 'categories'));
    }

    /**
     * Increments the total views
     * @param FAQ    $faq
     * @param string $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function incrementClick(FAQ $faq, $type = 'total_read'): \Illuminate\Http\JsonResponse
    {
        if ($type === 'total_read' || $type === 'helpful_yes' || $type === 'helpful_no') {
            $faq->increment($type);
        }

        return json_response('');
    }
}
