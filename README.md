# Laravel E-commerce (Docker)

## Prerequisites

- Docker Desktop (or Docker Engine) and Docker Compose

## Project Structure

- App source: `source/`
- PHP-FPM app container: `app`
- Nginx web container: `web` (exposes http://localhost:8000)
- MySQL database: `mysql` (inside network on port 3306)

## Quick Start

1. Build and start containers

```bash
docker compose up -d --build
```

2. Prepare application (run inside the `app` container)

```bash
docker compose exec app cp .env.example .env
docker compose exec app php artisan key:generate
docker compose exec app php artisan migrate --seed
docker compose exec app php artisan storage:link
```

3. Open the app

- Browser: http://localhost:8000

## Environment Notes

- Database connection (already correct in Docker network):
     - DB_HOST=mysql
     - DB_PORT=3306
     - DB_DATABASE=laravel
     - DB_USERNAME=laravel
     - DB_PASSWORD=secret

If needed, edit these in `source/.env` then run:

```bash
docker compose exec app php artisan config:clear
```

## Common Commands

- View logs

```bash
docker compose logs -f
```

- Run artisan

```bash
docker compose exec app php artisan <command>
```

- Run tests

```bash
docker compose exec app php artisan test
```

- Stop containers

```bash
docker compose down
```

## API (User Module)

Base URL: `http://localhost:8000/api/v1`

- List users (supports filter/sort/include/pagination)

```bash
curl "http://localhost:8000/api/v1/users?per_page=10&filter[name]=a&sort=-created_at"
```

- Create user

```bash
curl -X POST http://localhost:8000/api/v1/users \
  -H 'Content-Type: application/json' \
  -d '{"name":"Admin","email":"admin+1@example.com","password":"password"}'
```

- Show user

```bash
curl http://localhost:8000/api/v1/users/1
```

- Update user

```bash
curl -X PUT http://localhost:8000/api/v1/users/1 \
  -H 'Content-Type: application/json' \
  -d '{"name":"Admin Updated"}'
```

- Delete user

```bash
curl -X DELETE http://localhost:8000/api/v1/users/1
```

## Seed Data

The database seeder creates an admin and 20 random users.

- Rerun user seeder:

```bash
docker compose exec app php artisan db:seed --class=Database\\Seeders\\UserSeeder
```

## Frontend (optional)

If you add Vite/Node, run Node locally or add a Node container. Current Nginx serves `public/` only; API is ready.
