<?php

namespace App\Services\Shopify\Graphql;

use App\Exceptions\ShopifyGraphqlException;
use App\Services\Shopify\BaseService;

class ProductService extends BaseService
{
    /**
     * Get list of products from Shopify
     *
     * @param array $params
     *
     * @return mixed
     * @throws ShopifyGraphqlException
     */
    public function list(array $params): mixed
    {
        $query = <<<'GRAPHQL'
        query GetProducts(
            $first: Int,
            $last: Int,
            $before: String,
            $after: String,
            $query: String,
            $sort_key: ProductSortKeys,
        ) {
            products(
                first: $first,
                last: $last,
                before: $before,
                after: $after,
                query: $query,
                sortKey: $sort_key,
            ) {
                edges {
                    cursor
                    node {
                        id
                        handle
                        title
                        image: featuredImage {
                            url
                        }
                    }
                }
                pageInfo {
                    endCursor
                    startCursor
                    hasNextPage
                    hasPreviousPage
                }
            }
        }
        GRAPHQL;

        $response = $this->getShop()->graph($query, $params);

        return data_get($response, 'body.data.products');
    }

    /**
     * Get single product from shopify
     *
     * @param array $params
     *
     * @return array|mixed
     * @throws ShopifyGraphqlException
     */
    public function get(array $params): mixed
    {
        $query = <<<'GRAPHQL'
        query GetProduct($id: ID!) {
            product(
                id: $id,
            ) {
                id
                handle
                title
                image: featuredImage {
                    url
                }
            }
        }
        GRAPHQL;

        $response = $this->getShop()->graph($query, $params);
        return data_get($response, 'body.data.product');
    }
}
