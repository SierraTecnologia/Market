<?php

namespace Market\Http\Controllers;

use Illuminate\Http\Request;
use Market\Http\Controllers\Controller;
use Market\Services\CartService;
use Muleta\Modules\Controllers\Api\ApiControllerTrait;
use Redirect;
use StoreHelper;

class CartController extends Controller
{
    use ApiControllerTrait;
    
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cart = $cartService;
    }

    /**
     * Show the cart contents
     *
     * @return \Illuminate\Http\Response
     */
    public function getContents()
    {
        $products = $this->cart->contents();

        return view('market::cart.all')->with('products', $products);
    }

    /**
     * Empty the contents of the cart
     *
     * @return \Illuminate\Http\Response
     */
    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
