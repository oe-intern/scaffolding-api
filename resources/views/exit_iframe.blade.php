<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Security-Policy" content="frame-src {{ asset('') }}">
    <title>Redirecting...</title>
    <meta name="shopify-api-key" content="{{ config('shopify-app.api_key') }}" />
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js" ></script>
</head>
<body>
<script>
    var permissionUrl = '{!! $redirect_url !!}'
    open(permissionUrl, '_top')
</script>
</body>
</html>
