<?php

namespace Market\Http\Controllers;

use Market\Http\Controllers\Controller;
use Market\Repositories\ProductRepository;
use Market\Services\PlanService;

class StoreController extends Controller
{
    protected $productsRepository;

    public function __construct(ProductRepository $productRepository, PlanService $planService)
    {
        $this->products = $productRepository;
        $this->plans = $planService;
    }

    /**
     * Display the store front.
     *
     * @param int $id
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $products = $this->products->getPublishedProducts()->paginate(25);
        $plans = $this->plans->allEnabled();

        if (empty($products)) {
            abort(404);
        }

        return view('market::storefront')
            ->with('plans', $plans)
            ->with('products', $products);
    }
}
