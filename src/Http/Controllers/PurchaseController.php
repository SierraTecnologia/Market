<?php

namespace Market\Http\Controllers;

use Market\Http\Controllers\Controller;
use Auth;
use Market\Repositories\TransactionRepository;

class PurchaseController extends Controller
{
    public function __construct(TransactionRepository $transactionRepo)
    {
        $this->transactions = $transactionRepo;
    }

    /**
     * List all customer purchases
     *
     * @return Illuminate\Http\Response
     */
    public function allPurchases()
    {
        $purchases = $this->transactions->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('siravel.pagination'));

        return view('market::purchases.all')
            ->with('purchases', $purchases);
    }

    /**
     * View a customer purchase
     *
     * @return Illuminate\Http\Response
     */
    public function getPurchase($id)
    {
        $purchase = $this->transactions->getByCustomerAndUuid(auth()->id(), $id);

        return view('market::purchases.purchase')
            ->with('purchase', $purchase);
    }

    /**
     * Request a refund for a purchase
     *
     * @return Illuminate\Http\Response
     */
    public function requestRefund($id)
    {
        $purchase = $this->transactions->requestRefund(auth()->id(), $id);

        return view('market::purchases.refund');
    }
}
