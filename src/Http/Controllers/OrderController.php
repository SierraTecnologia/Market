<?php

namespace Market\Http\Controllers;

use Market\Http\Controllers\Controller;
use Market\Repositories\OrderRepository;
use Market\Services\OrderService;

class OrderController extends Controller
{
    public function __construct(OrderRepository $orderRepo)
    {
        $this->orders = $orderRepo;
    }

    /**
     * List all customer orders
     *
     * @return Illuminate\Http\Response
     */
    public function allOrders()
    {
        $orders = $this->orders->getByCustomer(auth()->id())->orderBy('created_at', 'DESC')->paginate(config('siravel.pagination'));

        return view('market::orders.all')->with('orders', $orders);
    }

    /**
     * Get a customer order
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function getOrder($id)
    {
        $order = $this->orders->getByCustomerAndUuid(auth()->id(), $id);

        return view('market::orders.order')->with('order', $order);
    }

    /**
     * Cancel a customer order
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function cancelOrder($id)
    {
        if (app(OrderService::class)->cancelOrder(auth()->id(), $id)) {
            return back()->with('message', 'Order cancelled');
        }

        return back();
    }
}
