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

Headers (apply to every request unless stated):

- `Accept: application/json`
- `Accept-Language: ar | fr | en`

Requests that require token authentication are marked with 🔒; include header:

- `Authorization: Bearer <token>`

### Auth
Authentication-related endpoints.

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

### Listings
Property listing endpoints for browsing, filtering, and retrieving rental properties.

#### Get All Listings (with Filters)
- URL: `/api/listings`
- Method: `GET`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Query Parameters:
	- `per_page` (optional): Number of results per page (default: 4)
	- `search` (optional): Search in title and description
	- `type_id` (optional): Filter by property type (1 = rent, 2 = sale, etc.)
	- `rent_duration_id` (optional): Filter by rent duration (only if type_id = 1)
	- `city_id` (optional): Filter by city
	- `category_ids[]` (optional): Filter by categories (array, multi-select)
	- `feature_ids[]` (optional): Filter by features (array, multi-select)
	- `near_place_ids[]` (optional): Filter by nearby places (array, multi-select)
- Success Response (200):
```
{
	"success": true,
	"message": "Listings retrieved successfully",
	"data": {
		"listing": [
			{
                "id": 1,
                "title": "شقة عصرية في وسط المدينة",
                "description": "شقة جميلة ومجهزة بالكامل تقع في قلب المدينة، قريبة من جميع المرافق مثل المحلات التجارية ووسائل النقل. مناسبة للعائلات أو الأزواج.",
                "price": "45000.00",
                "floor": 3,
                "surface": "95.00",
                "min_duration": 6,
                "number_rooms": 3,
                "number_persons": 5,
                "is_ready": true,
                "is_negotiable": false,
                "boost_level": 1,
                "moderation_status": "approved",
                "image": "listings/img-1.jpg",
                "rent_duration": {
                    "id": 1,
                    "name": "يومي"
                },
                "location": {
                    "id": 1,
                    "latitude": "36.36500000",
                    "longitude": "6.61470000",
                    "zip_code": "25000",
                    "city": "قسنطينة",
                    "wilaya": "قسنطينة",
                    "Wilaya_code": "25",
                    "country": "الجزائر"
                },
                "categories": [
                    {
                        "id": 1,
                        "name": "شقة",
                        "icon_path": "/storage/category_listings/apartment.png"
                    }
                ],
                "features": [
                    {
                        "id": 1,
                        "name": "تلفاز",
                        "icon_path": "/storage/featured_listings/tv.png"
                    },
                    {
                        "id": 2,
                        "name": "مسبح",
                        "icon_path": "/storage/featured_listings/pool.png"
                    }
                ],
                "near_places": [
                    {
                        "id": 1,
                        "name": "مسجد",
                        "icon_path": "/storage/near_places/mosque.png"
                    }
                ],
                "time_post": "2026-03-02T15:37:31.000000Z"
            },
		],
		"pagination": {
            "total": 5,
            "count": 2,
            "per_page": 2,
            "current_page": 1,
            "total_pages": 3,
            "has_pages": true,
            "has_more_pages": true,
            "first_page_url": "http://127.0.0.1:8000/api/listings?page=1",
            "last_page_url": "http://127.0.0.1:8000/api/listings?page=3",
            "next_page_url": "http://127.0.0.1:8000/api/listings?page=2",
            "prev_page_url": null,
            "from": 1,
            "to": 2,
            "path": "http://127.0.0.1:8000/api/listings",
            "current_page_url": "http://127.0.0.1:8000/api/listings?page=1"
        }
	}
}
```

#### 🔒 Create New Listing
- URL: `/api/listings`
- Method: `POST`
- Auth: required (`auth:sanctum`)
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
	- `Authorization: Bearer <token>`
	- `Content-Type: multipart/form-data`
- Request Body (multipart/form-data):
```json
{
	"title": "Modern apartment in city center",
	"description": "Beautiful fully equipped apartment",
	"price": 45000,
	"floor": 3,
	"surface": 95.5,
	"boost_level": 7,
	"min_duration": 6,
	"number_rooms": 3,
	"number_persons": 5,
	"is_ready": true,
	"is_negotiable": false,
	"main_image": "<file>",
	"images[]": ["<file1>", "<file2>"],
	"member_id": 1,
	"rent_duration_id": 1,
	"type_id": 1,
	"location": {
		"latitude": 36.365,
		"longitude": 6.6147,
		"altitude": 640,
		"zip_code": "25000",
		"city_id": 1
	},
	"categories": [1, 2],
	"features": [1, 2, 3],
	"near_places": [1, 2]
}
```
- Success Response (201):
```json
{
	"success": true,
	"message": "Listing created successfully",
	"data": { /* Listing object */ }
}
```

#### Get Single Listing
- URL: `/api/listings/{id}`
- Method: `GET`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Success Response (200):
```json
{
	"success": true,
	"message": "Listing retrieved successfully",
	"data": { /* Complete Listing object with all relations */ }
}
```

#### 🔒 Update Listing
- URL: `/api/listings/{id}`
- Method: `PUT` or `PATCH`
- Auth: required (`auth:sanctum`)
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
	- `Authorization: Bearer <token>`
	- `Content-Type: multipart/form-data`
- Request Body: All fields are optional (only send fields to update)
```json
{
	"title": "Updated title",
	"price": 50000,
	"main_image": "<file>",
	"images[]": ["<new_files>"],
	"location": {
		"latitude": 36.365,
		"longitude": 6.6147,
		"city_id": 1
	}
}
```
- Success Response (200):
```json
{
	"success": true,
	"message": "Listing updated successfully",
	"data": { /* Updated Listing object */ }
}
```

#### 🔒 Delete Listing
- URL: `/api/listings/{id}`
- Method: `DELETE`
- Auth: required (`auth:sanctum`)
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
	- `Authorization: Bearer <token>`
- Success Response (200):
```json
{
	"success": true,
	"message": "Listing deleted successfully"
}
```
- Note: This permanently deletes the listing, its location, all images (main + gallery), and all relations (categories, features, near_places)

#### Get Listing Details Metadata
Get all available options for filtering listings (types, categories, features, etc.)
- URL: `/api/listings/details`
- Method: `GET`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Success Response (200):
```json
{
	"success": true,
	"message": "Listings retrieved successfully",
	"data": {
		"features": [
			{"id": 1, "name": "Swimming Pool", "icon_path": "/storage/featured_listings/pool.png"},
			{"id": 2, "name": "Parking", "icon_path": "/storage/featured_listings/parking.png"}
		],
		"categories": [
			{"id": 1, "name": "Apartment", "icon_path": "/storage/category_listings/apartment.png"},
			{"id": 2, "name": "House", "icon_path": "/storage/category_listings/house.png"}
		],
		"near_places": [
			{"id": 1, "name": "School", "icon_path": "/storage/near_places/school.png"},
			{"id": 2, "name": "Hospital", "icon_path": "/storage/near_places/hospital.png"}
		],
		"types": [
			{"id": 1, "name": "Rent"},
			{"id": 2, "name": "Sale"}
		],
		"rent_durations": [
			{"id": 1, "name": "Daily"},
			{"id": 2, "name": "Monthly"},
			{"id": 3, "name": "Yearly"}
		]
	}
}
```

#### Get All Wilayas
- URL: `/api/listings/wilayas`
- Method: `GET`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Success Response (200):
```json
{
	"success": true,
	"message": "Listings retrieved successfully",
	"data": {
		"wilayas": [
			{"id": 1, "name": "Alger", "code": "16"},
			{"id": 2, "name": "Oran", "code": "31"},
			{"id": 3, "name": "Constantine", "code": "25"}
		]
	}
}
```

#### Get Cities by Wilaya
- URL: `/api/listings/cities`
- Method: `GET`
- Auth: none
- Headers:
	- `Accept: application/json`
	- `Accept-Language: ar | fr | en`
- Query Parameters:
	- `wilaya_id` (required): Wilaya ID to get cities for
- Success Response (200):
```json
{
	"success": true,
	"message": "Listings retrieved successfully",
	"data": {
		"cities": [
			{"id": 1, "name": "Algiers Centre"},
			{"id": 2, "name": "Bab El Oued"},
			{"id": 3, "name": "Hydra"}
		]
	}
}
```
- Error Response (422):
```json
{
	"message": "The wilaya_id field is required.",
	"errors": {
		"wilaya_id": ["The wilaya_id field is required."]
	}
}
```

Notes:
- Controller implementation: [app/Http/Controllers/Api/Listing/ListingController.php](app/Http/Controllers/Api/Listing/ListingController.php)
- Details controller: [app/Http/Controllers/Api/Listing/DetailsController.php](app/Http/Controllers/Api/Listing/DetailsController.php)
- Filter implementation: [app/Filters/ListingFilter.php](app/Filters/ListingFilter.php)
- Store request validation: [app/Http/Requests/Listing/StoreRequest.php](app/Http/Requests/Listing/StoreRequest.php)
- Update request validation: [app/Http/Requests/Listing/UpdateRequest.php](app/Http/Requests/Listing/UpdateRequest.php)
- Listings include related data: member, location hierarchy (country/wilaya/city), rent duration, categories, features, and nearby places
- Multi-select filters accept arrays: `?category_ids[]=1&category_ids[]=2&feature_ids[]=3`
- The filter logic applies AND conditions between different filter types
- Image uploads support: jpg, jpeg, png, webp (max 2MB per file)
- Update endpoint replaces all gallery images if new ones are provided

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
