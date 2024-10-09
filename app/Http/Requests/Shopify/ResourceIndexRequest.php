<?php

namespace App\Http\Requests\Shopify;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class ResourceIndexRequest extends FormRequest
{
    /**
     * Maximum resources should get from shopify per request
     */
    public const MAXIMUM_RESOURCE_AMOUNT = 20;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'after' => 'nullable|string',
            'before' => 'nullable|string',
            'limit' => 'nullable|int|min:1|max:' . self::MAXIMUM_RESOURCE_AMOUNT,
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function validated($key = null, $default = null)
    {
        $input = parent::validated();
        $limit = Arr::get($input, 'limit', self::MAXIMUM_RESOURCE_AMOUNT);

        if (Arr::has($input, 'before')) {
            $input['last'] = (int) $limit;
        } else {
            $input['first'] = (int) $limit;
        }

        unset($input['limit']);

        return data_get($input, $key, $default);
    }
}
