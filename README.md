
# Product Management API

A robust Laravel-based REST API for managing products with full CRUD operations, authentication, and comprehensive testing. This application serves as a complete backend solution for product inventory management, featuring secure API endpoints built with Laravel 12 and Sanctum authentication.

## Features

- **Product Management:** Complete CRUD operations for products (Create, Read, Update, Delete)
- **Authentication:** Secure API endpoints with Laravel Sanctum token-based authentication
- **Validation:** Comprehensive input validation with custom error responses
- **Pagination:** Efficient product listing with pagination support
- **Filtering:** Filter products by active status and other criteria
- **Testing:** Full test coverage with Pest testing framework
- **API Documentation:** Detailed API documentation with examples
- **Clean Architecture:** Organized code structure following Laravel best practices

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 8.4
- Composer
- A database server (SQLite, MySQL, PostgreSQL, etc.)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/hannanmiah/assignment-crud-backend.git
   cd assignment-crud-backend
   ```

2. **Install dependencies:**
   ```bash
   composer install
   ```

3. **Set up your environment:**
   - Copy the `.env.example` file to `.env`:
     ```bash
     cp .env.example .env
     ```
   - Generate an application key:
     ```bash
     php artisan key:generate
     ```
   - Configure your database connection in the `.env` file. For example, for SQLite:
     ```
     DB_CONNECTION=sqlite
     ```
     *Note: If you're not using SQLite, make sure to create the database and update the `DB_*` variables accordingly.*

4. **Run the database migrations:**
   ```bash
   php artisan migrate
   ```

5. **For Seeding:**
   ```bash
   php artisan db:seed
   ```

6. **Start the development server:**
   ```bash
   php artisan serve
   ```
   The API will be available at `http://localhost:8000`.

## API Documentation

All endpoints are prefixed with `/api` and require authentication using Laravel Sanctum. You must include an `Authorization: Bearer <token>` header in all requests (except register and login).

### Authentication

- **`POST /auth/register`**: Register a new user and receive an API token.
  - **Parameters:** `name`, `email`, `password`, `password_confirmation`
  - **Response:** `201 Created` with a Sanctum token.

- **`POST /auth/login`**: Authenticate and receive an API token.
  - **Parameters:** `email`, `password`
  - **Response:** `200 OK` with a Sanctum token.

- **`POST /auth/logout`**: Logout and invalidate the API token.
  - **Authentication:** Required.
  - **Response:** `204 No Content`.

### Products

- **`GET /products`**: Get a paginated list of products.
  - **Authentication:** Required.
  - **Query Parameters:** `is_active` (boolean filter), `page` (pagination)
  - **Response:** `200 OK` with paginated product data and pagination metadata.

- **`POST /products`**: Create a new product.
  - **Authentication:** Required.
  - **Parameters:** `name`, `description`, `price`, `stock`, `is_active` (optional)
  - **Response:** `201 Created` with the new product data.

- **`GET /products/{id}`**: Get a specific product.
  - **Authentication:** Required.
  - **Response:** `200 OK` with the product data.

- **`PUT /products/{id}`**: Update a product.
  - **Authentication:** Required.
  - **Parameters:** All fields are optional: `name`, `description`, `price`, `stock`, `is_active`
  - **Response:** `200 OK` with the updated product data.

- **`DELETE /products/{id}`**: Delete a product.
  - **Authentication:** Required.
  - **Response:** `200 OK` with success message.

### Detailed Documentation

For comprehensive API documentation including detailed request/response examples, error handling, and authentication guides, see: **[API Documentation](api-docs.md)**

## Testing

The application includes comprehensive test coverage using Pest. To run the test suite:

```bash
# Run all tests
php artisan test

# Run specific test file
php artisan test tests/Feature/ProductTest.php

# Run tests with coverage
php artisan test --coverage
```

Test coverage includes:
- Authentication flows (register, login, logout)
- Product CRUD operations (Create, Read, Update, Delete)
- Input validation and error handling
- Authorization and security
- Edge cases and error scenarios

## Project Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── AuthenticationController.php
│   │   └── ProductController.php
│   ├── Requests/
│   │   ├── StoreProductRequest.php
│   │   └── UpdateProductRequest.php
│   └── Resources/
│       └── ProductResource.php
├── Models/
│   ├── User.php
│   └── Product.php
database/
├── factories/
│   ├── ProductFactory.php
│   └── UserFactory.php
├── migrations/
└── seeders/
tests/
├── Feature/
│   └── ProductTest.php
```

## Built With

- **[Laravel 12](https://laravel.com/)** - Modern PHP framework with streamlined architecture
- **[Laravel Sanctum](https://laravel.com/docs/sanctum)** - Secure API authentication with tokens
- **[Pest 4](https://pestphp.com/)** - Elegant and developer-friendly testing framework
- **[Laravel Pint](https://laravel.com/docs/pint)** - Code formatter for maintaining code style
- **[SQLite](https://www.sqlite.org/)** - Lightweight database for development and testing

## Contributing

Thank you for considering contributing to the Product Management API! Please feel free to create a pull request or open an issue for any improvements or bug reports.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
