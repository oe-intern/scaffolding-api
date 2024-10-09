<?php

namespace App\Http\Resources\Shopify;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ShopifyResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $result = [];
        $resource = $this->resource;

        if ($container = data_get($resource, 'container')) {
            $resource = $container;
        }

        if (!$resource) {
            return null;
        }

        foreach ($resource as $key => $value) {
            $key = Str::snake($key);
            if (is_array($value)) {
                if (Arr::has($value, 'edges') || Arr::has($value, 'nodes')) {
                    $result[$key] = self::collection($value);

                    continue;
                }

                $result[$key] = new self($value);

                continue;
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * Collection
     *
     * @param mixed $resource
     *
     * @return array|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function collection($resource)
    {
        if ($container = data_get($resource, 'container')) {
            $resource = $container;
        }

        $start_cursor = null;
        $end_cursor = null;
        $page_info = Arr::get($resource, 'pageInfo');
        $data = [];

        $end_cursor = Arr::get($page_info, 'endCursor');
        $start_cursor = Arr::get($page_info, 'startCursor');
        $has_next_page = Arr::get($page_info, 'hasNextPage');
        $has_previous_page = Arr::get($page_info, 'hasPreviousPage');

        $nodes = Arr::get($resource, 'nodes', is_array($resource) ? $resource : []);

        if ($edges = Arr::get($resource, 'edges')) {
            $nodes = Arr::pluck($edges, 'node');
            $last = Arr::last($edges);
            $first = Arr::first($edges);
        }

        if (!$nodes) {
            return compact('data');
        }

        $data = array_map(function ($node) {
            return (new self($node))->resolve();
        }, $nodes);

        $meta = [
            'end_cursor' => $end_cursor,
            'start_cursor' => $start_cursor,
            'has_next_page' => $has_next_page,
            'has_previous_page' => $has_previous_page,
        ];

        return compact('data', 'meta');
    }
}
