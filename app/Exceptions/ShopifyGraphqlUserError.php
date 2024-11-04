<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShopifyGraphqlUserError extends BadRequestHttpException
{
    /**
     * @var
     */
    protected $errors;

    /**
     * ShopifyGraphqlUserError constructor.
     *
     * @param $errors
     */
    public function __construct($errors)
    {
        parent::__construct('Shopify GraphQL User Error');

        $this->errors = $errors;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        $errors = [];

        foreach ($this->errors as $error) {
            $errors[] = Arr::get($error, 'message');
        }

        return response()->json([
            'message' => $this->getMessage(),
            'errors' => $errors,
        ], 400);
    }
}
