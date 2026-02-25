# Docker usage

Build and start the stack:

```bash
docker-compose up --build -d
```

Stop the stack:

```bash
docker-compose down
```

Run artisan commands:

```bash
docker-compose exec app php artisan migrate
docker-compose exec app php artisan tinker
```

Install composer packages inside container:

```bash
docker-compose run --rm app composer install
```

Files added:

- [Dockerfile](Dockerfile)
- [docker-compose.yml](docker-compose.yml)
- [docker/nginx/default.conf](docker/nginx/default.conf)
- [.dockerignore](.dockerignore)

Production (Render) notes

There is a production multi-stage Dockerfile at `Dockerfile.render` that:

- builds frontend assets with Node
- installs PHP dependencies with Composer
- packages the app with `nginx` + `php-fpm`
- uses `docker/start.sh` and `docker/nginx/default.conf.template` to respect the `$PORT` env

Build and push an image to Docker Hub (example):

```bash
# build
docker build -f Dockerfile.render -t YOUR_DOCKERHUB_USER/backend_menzili:latest .
# login
docker login
# push
docker push YOUR_DOCKERHUB_USER/backend_menzili:latest
```

Deploying on Render using a pushed image:

1. On Render, create a new "Web Service" → choose "Private Service with Docker" or "Container".
2. For container registry, select Docker Hub and provide `YOUR_DOCKERHUB_USER/backend_menzili:latest`.
3. Set environment variables from your `.env` (DB credentials, APP_KEY, etc.).
4. Render will pull and run the image. Ensure the `PORT` env on Render matches the service port (Render sets `$PORT` automatically; `start.sh` will use it).

Or let Render build from repo: create a Web Service and point it to this repository; Render will run `docker build` using `Dockerfile.render` if you specify it as the build command.
