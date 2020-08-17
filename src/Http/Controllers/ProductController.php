<?php

namespace Market\Http\Controllers;

use Market\Http\Controllers\Controller;
use Market\Repositories\ProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->repository = $productRepository;
    }

    /**
     * Display all product entries.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function all()
    {
        $products = $this->repository->getPublishedProducts()->paginate(25);

        if (empty($products)) {
            abort(404);
        }

        return view('market::products.all')->with('products', $products);
    }

    /**
     * Display the specified product.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function show($url)
    {
        $product = $this->repository->findProductByURL($url);

        if (empty($product)) {
            abort(404);
        }

        return view('market::products.show')->with('product', $product);
    }

    /**
     * Display the customer favorite products.
     *
     * @param int $id
     *
     * @return Illuminate\Http\Response
     */
    public function favorites()
    {
        $products = $this->repository->favorites();

        return view('market::products.favorites')->with('products', $products);
    }
}
