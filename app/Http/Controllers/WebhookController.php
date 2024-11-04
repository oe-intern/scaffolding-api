<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Shopify\Exception\InvalidWebhookException;
use Shopify\Exception\MissingWebhookHandlerException;
use Shopify\Webhooks\Registry;

class WebhookController extends Controller
{
    /**
     * Handle the incoming webhook.
     *
     * @param $topic
     * @param Request $request
     * @return Response
     * @throws InvalidWebhookException
     * @throws MissingWebhookHandlerException
     */
    public function handle(Request $request)
    {
        Registry::process($request->header(), $request->getContent());

        return response()->noContent();
    }
}
