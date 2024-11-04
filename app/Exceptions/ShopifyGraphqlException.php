<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Arr;

class ShopifyGraphqlException extends Exception
{
    /**
     * @var
     */
    protected $errors;

    /**
     * ShopifyGraphqlException constructor.
     *
     * @param $errors
     */
    public function __construct($errors)
    {
        parent::__construct(self::summarize($errors));

        foreach ($errors as $error) {
            $code = Arr::get($error, 'extensions.code', 'OTHER');
            $this->errors[$code][] = Arr::get($error, 'message', 'Unknown error');
        }
    }

    /**
     * Summarize the errors.
     *
     * @param $errors
     * @return string
     */
    protected static function summarize($errors)
    {
        $first_error = Arr::first($errors);
        $message = Arr::get($first_error, 'message', 'Unknown error');
        $total_errors = count($errors);

        if ($total_errors > 1) {
            $total_errors_left = $total_errors - 1;
            $pluralized = $total_errors_left === 1 ? 'error' : 'errors';
            $message .= " (and $total_errors_left more $pluralized)";
        }

        return "Shopify GraphQL Error: {$message}";
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
        ], 500);
    }
}
