<?php

namespace App\Contracts\Shopify\Graphql;

interface Shop
{
    /**
     * Get the shop details.
     *
     * @return mixed
     */
    public function detail();
}
