<?php

namespace App\Http\Controllers\Admin\Shop;

use App\Http\Controllers\Traits\PrintOrderHelper;
use App\Http\Requests;
use App\Models\ProductStatus;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AdminController;

class TransactionsController extends AdminController
{
    use PrintOrderHelper;

    /**
     * List latest transactions
     * @return $this
     */
    public function index()
    {
        $items = Transaction::with('user.shippingAddress')
            ->with('products')
            ->with('shippingAddress')
            ->orderBy('created_at')
            ->get()
            ->take(200);

        $statuses = ProductStatus::getAllList();

        return $this->view('shop.transactions.index', compact('items'))
            ->With('statuses', $statuses);
    }

    /**
     * Show Transaction
     * @param Transaction $transaction
     * @return mixed
     */
    public function show(Transaction $transaction)
    {
        return $this->view('shop.transactions.show')->with('item', $transaction);
    }

    /**
     * Update the status
     * @param Transaction $transaction
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(Transaction $transaction)
    {
        if (input('status_id') > 0) {
            $transaction->update(['status_id' => input('status_id')]);
        }

        return json_response();
    }

    /**
     * @param Transaction $transaction
     * @param string      $format
     * @return TransactionsController
     */
    public function printOrder(Transaction $transaction, $format = "pdf")
    {
        return $this->createPDFAndShowOrder($transaction, $format);
    }
}