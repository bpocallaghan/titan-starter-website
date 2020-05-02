<?php

namespace App\Http\Controllers\Website\Account;

use App\Http\Controllers\Traits\PrintOrderHelper;
use App\Http\Requests;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Website\WebsiteController;

class AccountController extends WebsiteController
{
    use PrintOrderHelper;

    public function index()
    {

        $totalTransactions = $this->fetchTransactions()->count();

        return $this->view('account.account')
            ->with('totalTransactions', $totalTransactions);
    }

    private function fetchTransactions()
    {
        return Transaction::with('user')
            ->with('products')
            ->where('user_id', user()->id)
            ->orderBy('created_at', 'DESC')
            ->get();
    }

    public function transactions()
    {
        $items = $this->fetchTransactions();

        return $this->view('account.transactions', compact('items'));
    }

    /**
     * Show the details of the order
     * @param $reference
     * @return AccountController|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function showTransaction($reference)
    {
        $item = Transaction::where('reference', $reference)->where('user_id', user()->id)->first();

        if (!$item) {
            return redirect('/');
        }

        //$this->addBreadcrumbLink("View Order - N$" . $item->amount, '#');

        return $this->view('account.transaction_show', compact('item'));
    }

    /**
     * Print Transaction
     * @param        $reference
     * @param string $format
     * @return AccountController|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function printTransaction($reference, $format = "pdf")
    {
        $transaction = Transaction::where('reference', $reference)->where('user_id', user()->id)->first();

        if (!$transaction) {
            return redirect('/');
        }

        return $this->createPDFAndShowOrder($transaction, $format);
    }
}