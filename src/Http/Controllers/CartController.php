<?php

namespace Market\Http\Controllers;

use Redirect;
use Illuminate\Http\Request;
use Market\Interfaces\Helpers\StoreHelper;
use Market\Http\Controllers\Controller;
use Market\Services\CartService;
use Muleta\Services\RiCaResponseService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService, RiCaResponseService $siravelResponseService)
    {
        $this->cart = $cartService;
        $this->responseService = $siravelResponseService;
    }

    /**
     * Show the cart contents
     *
     * @return Illuminate\Http\Response
     */
    public function getContents()
    {
        $products = $this->cart->contents();

        return view('market::cart.all')->with('products', $products);
    }

    /**
     * Get cart contents
     *
     * @return Illuminate\Http\Response
     */
    public function cart()
    {
        return $this->responseService->apiResponse('success', [
            'count' => $this->cart->itemCount(),
            'contents' => $this->cart->contents(),
            'shipping' => StoreHelper::moneyFormat($this->cart->getCartShipping()),
            'coupon' => StoreHelper::moneyFormat($this->cart->getCurrentCouponValue()),
            'tax' => StoreHelper::moneyFormat($this->cart->getCartTax()),
            'subtotal' => StoreHelper::moneyFormat($this->cart->getCartSubTotal()),
            'total' => StoreHelper::moneyFormat($this->cart->getCartTotal()),
        ]);
    }

    /**
     * Get cart item count
     *
     * @return Illuminate\Http\Response
     */
    public function cartCount()
    {
        $count = $this->cart->itemCount();

        return $this->responseService->apiResponse('success', $count);
    }

    /**
     * Change the amount of a cart item
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function changeCartCount(Request $request)
    {
        $count = $this->cart->changeItemQuantity($request->id, $request->count);

        return $this->responseService->apiResponse('success', $count);
    }

    /**
     * Add an item to the cart
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function addToCart(Request $request)
    {
        $result = $this->cart->addToCart($request->id, $request->type, $request->quantity, $request->variants);

        if ($result) {
            return $this->responseService->apiResponse('success', 'Added to Cart');
        }

        return $this->responseService->apiResponse('error', 'Could not be added to Cart');
    }

    /**
     * Remove an item from the cart
     *
     * @param Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function removeFromCart(Request $request)
    {
        $this->cart->removeFromCart($request->id, $request->type);

        return $this->responseService->apiResponse('success', 'Removed from Cart');
    }

    /**
     * Empty the contents of the cart
     *
     * @return Illuminate\Http\Response
     */
    public function emptyCart()
    {
        $this->cart->emptyCart();

        return Redirect::back();
    }
}
