<?php

namespace App\Http\Requests\Shopify;

use App\Enums\ProductSortKey;
use Illuminate\Validation\Rules\Enum;

class ProductIndexRequest extends ResourceIndexRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return array_merge(parent::rules(), [
            'query' => 'nullable|string',
            'sort_by' => ['nullable', new Enum(ProductSortKey::class)],
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function validated($key = null, $default = null)
    {
        $input = parent::validated();

        if (!data_get($input, 'sort_by')) {
            $input['sort_by'] = ProductSortKey::CreatedAt->value;
        }

        $input['metafield_namespace'] = config('shopify-app.custom_data.metafields.namespace');
        $input['metafield_key'] = config('shopify-app.custom_data.metafields.option_set_reference_key');

        return data_get($input, $key, $default);
    }
}
