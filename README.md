# Menzili — Backend (Laravel)

![Laravel](https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg)

A clean, well-documented backend API for the Menzili project built with Laravel. This repository contains the REST API, services (including Twilio integration), migrations, and tests required to run the Menzili backend locally or in Docker.

## Table of Contents
- Project Overview
- Key Features
- Requirements
- Quick Start
- Environment Variables
- Running with Docker
- API & Routes
- Testing
- Contributing
- License & Contact

## Project Overview

This Laravel application provides authentication, user management, and messaging services for the Menzili platform. It is structured for maintainability and rapid iteration, using Laravel conventions, service classes, and route grouping.

## Quick Start (local)
1. Install PHP dependencies: `composer install`
2. Copy the environment file: `cp .env.example .env` (or copy your `.env`)
3. Generate app key: `php artisan key:generate`
4. Configure `.env` (database, mail, Twilio credentials)
5. Run migrations & seeds: `php artisan migrate --seed`
6. Start the server: `php artisan serve`

When developing with assets (if needed):
```
npm install
npm run dev
```

## Swagger/OpenAPI Documentation
The API is fully documented using OpenAPI 3.0 specification with interactive Swagger UI.

**Access the Swagger documentation:**
- Open [http://domain_name/en/docs](en/docs) while the server is running


The `openapi.yaml` file contains all endpoint definitions with request/response schemas, making it easier to test endpoints and generate client code.

## API Documentation
### Auth
Authentication-related endpoints. I removed other routes — add other sections later and I'll document them similarly.

Headers (apply to every request unless stated):

- `Accept: application/json`
- `Accept-Language: ar | fr | en`

Requests that require token authentication are marked with 🔒; include header:

- `Authorization: Bearer <token>`

#### Request OTP (login)
- URL: `/api/auth/login`
- Method: `POST`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Request JSON:
```
{
	"phone": "+201234567890"
}
```
- Success Response (200):
```
{
	"success": true,
	"message": "OTP sent",
	"status": 200,
	"data": { "otp": "123456" }
}
```

#### Verify OTP
- URL: `/api/auth/valid-otp`
- Method: `POST`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Request JSON:
```
{
	"phone": "+201234567890",
	"otp_code": "123456"
}
```
- Success Response (200):
```
{
	"success": true,
	"message": "OTP verified",
	"status": 200,
	"data": {
		"token": "<plain-text-token>",
		"fill_name": false
	}
}
```
- Error Responses:
	- 404: user not found
	- 422: invalid or expired OTP

#### 🔒 Complete Profile (fill name)
- URL: `/api/auth/fill-name`
- Method: `POST`
- Auth: required (`auth:sanctum`)
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
	- `Authorization: Bearer <token>`
- Request JSON:
```
{
	"name": "Alice"
}
```
- Success Response (200):
```
{
	"success": true,
	"message": "Profile completed",
	"status": 200,
	"data": { "user": { /* user resource object */ } }
}
```

Notes:
- See controller implementations in [app/Http/Controllers/Api/AuthController.php](app/Http/Controllers/Api/AuthController.php) for validation rules and exact response shapes.
- Twilio WhatsApp sending is implemented in [app/Services/TwilioWhatsAppService.php](app/Services/TwilioWhatsAppService.php).

## Running with Docker
This project includes Docker configuration for development. To start using Docker:

1. Build and run containers:

```
docker-compose up -d --build
```

2. Install PHP dependencies inside the app container (if needed):

```
docker compose exec app composer install
docker compose exec app php artisan migrate --seed
```

See `docker` and `conf/nginx` folders for additional configuration details.

## API & Routes
- Public API routes: [routes/api.php](routes/api.php)
- Project-specific API routers: [routes/ApiRouters](routes/ApiRouters)

Authentication and API usage examples are in the controllers folder. For authentication flow, check controllers under [app/Http/Controllers](app/Http/Controllers) and routes under [routes/ApiRouters/Auth.php](routes/ApiRouters/Auth.php).

Example: to send a WhatsApp message the codepath is handled by the Twilio service at [app/Services/TwilioWhatsAppService.php](app/Services/TwilioWhatsAppService.php).

## Testing
Run the automated test suite:

```
composer test
# or
php artisan test
```

Tests are located in the `tests` directory and use Pest/PHPUnit.

## Contributing
Contributions are welcome. Please follow these steps:

1. Fork the repository
2. Create a feature branch
3. Write tests for new behavior
4. Open a pull request with a clear description

Please keep code style consistent with the existing project and run tests before submitting.

## Troubleshooting & Tips
- If migrations fail, ensure DB credentials in `.env` are correct.
- For Twilio: validate `TWILIO_SID` and `TWILIO_TOKEN` and ensure the `TWILIO_WHATSAPP_FROM` is registered for your Twilio account.
- If using Docker, use `docker compose exec app bash` to inspect the container.

## License
This project is open sourced under the MIT license.

## Contact
For questions or help, open an issue or contact the maintainer via the repository.

---
Updated README to be project-specific, with setup and documentation for local and Docker-based development.
