<?php

namespace App\Http\Controllers\Traits;

use App\Models\Transaction;

trait PrintOrderHelper
{
    private function createPDFAndShowOrder(Transaction $transaction, $format = "pdf")
    {
        // create pdf
        $view = view("pdf.order")->with('item', $transaction);

        // debug - show pdf
        if ($format == 'web') {
            return $view;
        }

        // show pdf
        $name = "Order - {$transaction->order_number}.pdf";

        return \PDF::loadHTML($view)->stream($name);
    }
}
