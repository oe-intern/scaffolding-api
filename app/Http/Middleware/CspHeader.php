<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Shopify\Context;
use Shopify\Utils;

class CspHeader
{
    /**
     * Ensures that the request is setting the appropriate CSP frame-ancestor directive.
     *
     * See https://shopify.dev/docs/apps/store/security/iframe-protection for more information
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $shop = Utils::sanitizeShopDomain($request->query('shop', ''));

        if (Context::$IS_EMBEDDED_APP) {
            $domain_host = $shop ? "https://$shop" : "*.myshopify.com";
            $allowed_domains = "$domain_host https://admin.shopify.com";
        } else {
            $allowed_domains = "'none'";
        }

        /** @var \Illuminate\Http\Response $response */
        $response = $next($request);

        $current_header = $response->headers->get('Content-Security-Policy');
        if ($current_header) {
            $values = preg_split("/;\s*/", $current_header);

            // Replace or add the URLs the frame-ancestors directive
            $found = false;
            foreach ($values as $index => $value) {
                if (mb_strpos($value, "frame-ancestors") === 0) {
                    $values[$index] = preg_replace("/^(frame-ancestors)/", "$1 $allowed_domains", $value);
                    $found = true;
                    break;
                }
            }

            if (!$found) {
                $values[] = "frame-ancestors $allowed_domains";
            }

            $header_value = implode("; ", $values);
        } else {
            $header_value = "frame-ancestors $allowed_domains;";
        }


        $response->headers->set('Content-Security-Policy', $header_value);

        return $response;
    }
}
