<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="robots" content="noindex">

    <meta name="shopify-api-key" content="{{ config('shopify-app.api_key') }}"/>
    @if (config('app.env') !== 'local')
        <link rel="preload" as="style" href="{{ $portal_url }}/assets/index.css?v={{ $v }}"/>
        <link rel="modulepreload" as="script" href="{{ $portal_url }}/assets/index.js?v={{ $v }}">
    @endif
    <script src="https://cdn.shopify.com/shopifycloud/app-bridge.js"></script>
    <title>{{ config('app.name') }}</title>
    @if (config('app.env') !== 'local')
        <link rel="stylesheet" href="{{ $portal_url }}/assets/index.css?v={{ $v }}"/>
        <script type="module" src="{{ $portal_url }}/assets/index.js?v={{ $v }}"></script>
    @endif
    @if (config('app.env') === 'local')
        <script type="module" src="{{ $portal_url }}/src/main.ts"></script>
    @endif
</head>

<body>
<div id="app">
</div>
<script>
    window.scaffoldingEmbeddedData = {
        user: <?php echo json_encode($user); ?>,
    };
</script>
</body>

</html>
