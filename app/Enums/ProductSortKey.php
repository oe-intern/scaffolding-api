<?php

namespace App\Enums;

enum ProductSortKey: string
{
    case CreatedAt = 'CREATED_AT';
    case Id = 'ID';
    case InventoryTotal = 'INVENTORY_TOTAL';
    case ProductType = 'PRODUCT_TYPE';
    case PublishedAt = 'PUBLISHED_AT';
    case Relevance = 'RELEVANCE';
    case Title = 'TITLE';
    case UpdatedAt = 'UPDATED_AT';
    case Vendor = 'VENDOR';
}
