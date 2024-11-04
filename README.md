# Shopify App Template
This backend template is a starting point for building Shopify apps with Laravel. 
This template is based on the [Shopify app PHP template](https://github.com/Shopify/shopify-app-template-php) and [Laravel-Shopify](https://github.com/gnikyt/laravel-shopify).
This is a powerful foundation for integrating Laravel with Shopify, making it easier to create and manage Shopify apps.
This backend template also includes a built-in admin panel and role-based permissions for your app.

## Getting started

### Requirements

1. You must [create a Shopify partner account](https://partners.shopify.com/signup) if you don’t have one.
2. You must create a store for testing if you don't have one, either a [development store](https://help.shopify.com/en/partners/dashboard/development-stores#create-a-development-store) or a [Shopify Plus sandbox store](https://help.shopify.com/en/partners/dashboard/managing-stores/plus-sandbox-store).
3. You must install docker and docker compose on your machine. You can find the installation instructions [here](https://docs.docker.com/).

## Tech Stack
This template combines a number of third party open source tools:

-   [Laravel](https://laravel.com/) builds and tests the backend.
-   [Filament](https://filamentphp.com/docs) provides the admin panel.
-   [Shopify API library](https://github.com/Shopify/shopify-api-php) adds OAuth to the Laravel backend. This lets users install the app and grant scope permissions.

### Cloning the repository

### Setting up your Laravel app

These are the typical steps needed to set up a Laravel app once it's cloned:

1. Copy `.env.example` to `.env`
2. Generate an `APP_KEY` for your app:

    ```shell
    php artisan key:generate
    ```
3. Create the necessary Shopify tables in your database:

    ```shell
    php artisan migrate
    ```
4. Install Laravel Sail and composer dependencies to vendor
    ```bash
    docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
    ```
5. Start the server
    ```bash
    ./vendor/bin/sail up -d
    ```
(Optional) Alias `sail` command add following line to your shell configuration file (e.g. ~/.bashrc, ~/.zshrc, etc.)
```bash
alias sail='sh $([ -f sail ] && echo sail || echo vendor/bin/sail)'
```
(If you want to exec into the api container, run `sail bash`)

More information: https://laravel.com/docs/11.x/sail#configuring-a-shell-alias

### Local Development

[The Shopify CLI](https://shopify.dev/docs/apps/tools/cli) connects to an app in your Partners dashboard.
It provides environment variables, runs commands in parallel, and updates application URLs for easier development.

Run one of the following commands from the root of your app:
    
```shell
yarn deploy:app
```

Open the URL generated in your console. Once you grant permission to the app, you can start development.

## Deployment

### Application Storage

This template uses [Laravel's Eloquent framework](https://laravel.com/docs/11.x/eloquent) to store Shopify session data.
It provides migrations to create the necessary tables in your database, and it stores and loads session data from them.
The database that works best for you depends on the data your app needs and how it is queried.

## Working with Filament Shield (Admin Permissions)
1. Make user model for filament
    ```bash
    sail artisan make:filament-user
    ```
2. Create a super admin user
    ```bash
    sail artisan shield:super-admin
    ```
3. Generate Permissions and/or Policies for Filament entities. Accepts the following flags:
    ```bash
    sail artisan shield:generate {--option} {--resource=} {--all} {--ignore-existing-policies}
    ```
   Example:
    ```bash
    sail artisan shield:generate --all --ignore-existing-policies
    ```
   More information: https://filamentphp.com/plugins/bezhansalleh-shiel

## Working with queue
run following command:
```bash
sail artisan queue:listen 
```
More information: https://laravel.com/docs/11.x/queues#the-queue-work-command

## Developer resources
-   [Introduction to Shopify apps](https://shopify.dev/docs/apps/getting-started)
-   [App authentication](https://shopify.dev/docs/apps/auth)
-   [Shopify CLI](https://shopify.dev/docs/apps/tools/cli)
-   [Shopify API Library documentation](https://github.com/Shopify/shopify-api-php/tree/main/docs)
-   [Getting started with internationalizing your app](https://shopify.dev/docs/apps/best-practices/internationalization/getting-started)
