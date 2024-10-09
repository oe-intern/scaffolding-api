<?php

namespace App\Exceptions;

use Illuminate\Support\Arr;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ShopifyGraphqlUserError extends BadRequestHttpException
{
    /**
     * @var iterable|object
     */
    protected $errors;

    /**
     * ShopifyGraphqlException constructor.
     *
     * @param $errors
     */
    public function __construct($errors)
    {
        $errorMessages = [];

        foreach ($errors as $error) {
            $errorMessages[] = Arr::get($error, 'message');
        }

        parent::__construct('Shopify GraphQL User Error: ' . implode(', ', $errorMessages));

        $this->errors = $errorMessages;
    }

    /**
     * Render the exception as an HTTP response.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function render()
    {
        return response()->json([
            'message' => $this->getMessage(),
            'errors' => $this->errors,
        ], 400);
    }
}
