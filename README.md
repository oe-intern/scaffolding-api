1. Install docker follow [this](https://docs.docker.com/desktop/install/linux/).
1. Run `cp .env.example .env` to copy from `.env.example` to `.env`.
1. Run `docker compose up -d`.
1. Create Shopify application and update `SHOPIFY_API_KEY` and `SHOPIFY_API_SECRET`.
1. Run `docker exec -it scaffolding-api sh` to access docker container shell. (Run `docker ps -a` to list running containers).
1. In container shell, run `composer install` to install required packages.
1. Run `php artisan key:generate` to generate application key.
