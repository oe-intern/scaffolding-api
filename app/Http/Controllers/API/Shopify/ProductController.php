<?php

namespace App\Http\Controllers\API\Shopify;

use App\Exceptions\ShopifyGraphqlException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shopify\ProductIndexRequest;
use App\Http\Resources\Shopify\ShopifyResource;
use App\Services\Shopify\Graphql\ProductService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    /**
     * Get list of products from Shopify
     *
     * @param ProductIndexRequest $request
     * @param ProductService $productService
     * @return AnonymousResourceCollection|array
     * @throws ShopifyGraphqlException
     */
    public function index(ProductIndexRequest $request, ProductService $productService)
    {
        $input = $request->validated();
        $result = $productService->list($input);

        return ShopifyResource::collection($result);
    }

    /**
     * Get single product from Shopify
     *
     * @param Request $request
     * @param string $shopifyId
     * @param ProductService $productService
     * @return ShopifyResource
     * @throws ShopifyGraphqlException
     */
    public function show(Request $request, string $shopifyId, ProductService $productService)
    {
        $result = $productService->get([
            'id' => 'gid://shopify/Product/' . $shopifyId,
        ]);

        return new ShopifyResource($result);
    }
}
