<?php

namespace Market\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Market;
use Market\Http\Controllers\SitecController;
use Market\Models\Products;
use Market\Repositories\ProductRepository;
use Market\Repositories\ProductVariantRepository;
use Response;

class ProductVariantController extends SitecController
{
    /**
     * Product Repository.
     *
     * @var Market\Repositories\ProductRepository
     */
    public $productRepository;

    /**
     * Product Variant Repository.
     *
     * @var Market\Repositories\ProductVariantRepository
     */
    public $productVariantRepository;

    public function __construct(
        ProductVariantRepository $productVariantRepository,
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
        $this->productVariantRepository = $productVariantRepository;
    }

    /**
     * Get a product's variants.
     *
     * @param int                     $id
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function variants($id, Request $request)
    {
        $product = $this->productRepository->find($id);

        if (empty($product)) {
            Market::notification('Product not found', 'warning');

            return redirect(route('admin.market.products.index'));
        }

        if ($this->productVariantRepository->addVariant($product, $request->all())) {
            Market::notification('Variant successfully added.', 'success');
        } else {
            Market::notification('Failed to add variant. Missing Key or Value.', 'warning');
        }

        return redirect(route('admin.market.products.edit', $id).'?tab=variants');
    }

    /**
     * Save a variant.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function saveVariant(Request $request)
    {
        $this->productVariantRepository->saveVariant($request->all());

        return Response::json(['success']);
    }

    /**
     * Delete a variant.
     *
     * @param Illuminate\Http\Request $request
     *
     * @return Illuminate\Http\Response
     */
    public function deleteVariant(Request $request)
    {
        $this->productVariantRepository->deleteVariant($request->all());

        return Response::json(['success']);
    }
}
