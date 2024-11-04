<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8"/>
    <link rel="icon" href="{{ asset('favicon.ico') }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta http-equiv="Content-Security-Policy" content="frame-src {{ asset('') }} https://widget.canny.io">
    <title>{{ config('app.name') }}</title>
    @if(config('app.env') != 'local')
        <script type="module" src="{{ config('app.portal_url') }}/assets/{{ $version }}.js" defer></script>
        <link rel="stylesheet" href="{{ config('app.portal_url') }}/assets/{{ $version }}.css"/>
    @endif
    <meta name="shopify-api-key" content="{{ $key }}" />
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js" ></script>
</head>
<body>
<div id="app"></div>
<script>
    window.shopifyAppEmbedded = {
        shop: "{{ $shop }}"
    }
</script>
@if(config('app.env') === 'local')
    <script type="module" src="{{ config('app.portal_url') }}/src/main.ts"></script>
@endif
</body>
</html>
