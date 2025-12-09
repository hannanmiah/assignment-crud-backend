# API Documentation

This document provides a detailed description of the API endpoints, including request parameters and response schemas.

## Authentication

All API endpoints require token-based authentication using Laravel Sanctum. To authenticate your requests, you need to include an `Authorization` header with a bearer token.

`Authorization: Bearer <your-token>`

### Authentication Endpoints

#### Register User
-   **Endpoint:** `POST /api/auth/register`
-   **Description:** Creates a new user account and returns an API token.
-   **Request Parameters:**

| Parameter | Type   | Description                      |
| --------- | ------ | -------------------------------- |
| `name`    | string | The user's full name.            |
| `email`   | string | The user's email address.        |
| `password` | string | The user's password (min 8 chars). |
| `password_confirmation` | string | Must match password. |

-   **Response Schema:**

```json
{
    "token": "1|abc123def456..."
}
```

#### Login User
-   **Endpoint:** `POST /api/auth/login`
-   **Description:** Authenticates a user and returns an API token.
-   **Request Parameters:**

| Parameter | Type   | Description                  |
| --------- | ------ | ---------------------------- |
| `email`   | string | The user's email address.    |
| `password` | string | The user's password.         |

-   **Response Schema:**

```json
{
    "token": "1|abc123def456..."
}
```

#### Logout User
-   **Endpoint:** `POST /api/auth/logout`
-   **Description:** Logs out the user and invalidates their API token.
-   **Authentication:** Required
-   **Response:** `204 No Content`

---

## Products

### 1. Get all products

-   **Endpoint:** `GET /api/products`
-   **Description:** Retrieves a paginated list of products with optional filtering.
-   **Authentication:** Required
-   **Query Parameters:**

| Parameter   | Type    | Description                              |
| ----------- | ------- | ---------------------------------------- |
| `is_active` | boolean | Filter by active status (0 or 1). Optional. |
| `page`      | integer | Page number for pagination. Defaults to 1. |

-   **Response Schema:**

```json
{
    "data": [
        {
            "id": 1,
            "name": "Premium Wireless Headphones",
            "description": "High-quality wireless headphones with noise cancellation and 20-hour battery life.",
            "price": 299.99,
            "stock": 50,
            "is_active": true,
            "created_at": "2025-12-09T17:03:34.000000Z",
            "updated_at": "2025-12-09T17:03:34.000000Z"
        }
    ],
    "pagination": {
        "current_page": 1,
        "last_page": 2,
        "per_page": 10,
        "total": 15
    }
}
```

### 2. Create a new product

-   **Endpoint:** `POST /api/products`
-   **Description:** Creates a new product.
-   **Authentication:** Required
-   **Request Parameters:**

| Parameter    | Type    | Description                              |
| ------------ | ------- | ---------------------------------------- |
| `name`       | string  | The product name (required, max 255 chars). |
| `description`| string  | The product description (required).     |
| `price`      | numeric | The product price (required, min 0, max 999999.99). |
| `stock`      | integer | The product stock quantity (required, min 0). |
| `is_active`  | boolean | Whether the product is active (optional, defaults to true). |

-   **Response Schema:**

```json
{
    "message": "Product created successfully",
    "data": {
        "id": 1,
        "name": "Premium Wireless Headphones",
        "description": "High-quality wireless headphones with noise cancellation and 20-hour battery life.",
        "price": 299.99,
        "stock": 50,
        "is_active": true,
        "created_at": "2025-12-09T17:03:34.000000Z",
        "updated_at": "2025-12-09T17:03:34.000000Z"
    }
}
```

### 3. Get a single product

-   **Endpoint:** `GET /api/products/{id}`
-   **Description:** Retrieves a single product by its ID.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "data": {
        "id": 1,
        "name": "Premium Wireless Headphones",
        "description": "High-quality wireless headphones with noise cancellation and 20-hour battery life.",
        "price": 299.99,
        "stock": 50,
        "is_active": true,
        "created_at": "2025-12-09T17:03:34.000000Z",
        "updated_at": "2025-12-09T17:03:34.000000Z"
    }
}
```

### 4. Update a product

-   **Endpoint:** `PUT /api/products/{id}`
-   **Description:** Updates a product's information.
-   **Authentication:** Required
-   **Request Parameters:**

| Parameter    | Type    | Description                              |
| ------------ | ------- | ---------------------------------------- |
| `name`       | string  | The product name (optional, max 255 chars). |
| `description`| string  | The product description (optional).     |
| `price`      | numeric | The product price (optional, min 0, max 999999.99). |
| `stock`      | integer | The product stock quantity (optional, min 0). |
| `is_active`  | boolean | Whether the product is active (optional). |

-   **Response Schema:**

```json
{
    "message": "Product updated successfully",
    "data": {
        "id": 1,
        "name": "Updated Product Name",
        "description": "Updated product description",
        "price": 199.99,
        "stock": 25,
        "is_active": false,
        "created_at": "2025-12-09T17:03:34.000000Z",
        "updated_at": "2025-12-09T17:15:42.000000Z"
    }
}
```

### 5. Delete a product

-   **Endpoint:** `DELETE /api/products/{id}`
-   **Description:** Deletes a product permanently.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "message": "Product deleted successfully"
}
```

---

## Error Responses

All endpoints may return error responses with appropriate HTTP status codes:

### 401 Unauthorized
```json
{
    "message": "Unauthenticated."
}
```

### 404 Not Found
```json
{
    "message": "No query results for model [App\\Models\\Product]"
}
```

### 422 Unprocessable Entity
```json
{
    "message": "The name field is required. (and 2 more errors)",
    "errors": {
        "name": [
            "The name field is required."
        ],
        "price": [
            "The price field must be at least 0."
        ],
        "stock": [
            "The stock field must be at least 0."
        ]
    }
}
```

---

## Statistics

### 1. Overview Statistics

-   **Endpoint:** `GET /api/statistics/overview`
-   **Description:** Retrieves high-level statistics about the application.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "data": {
        "total_products": 10,
        "active_products": 8,
        "inactive_products": 2,
        "total_users": 5,
        "total_stock_value": 15000.00,
        "out_of_stock_products": 2,
        "low_stock_products": 3
    }
}
```

### 2. Products Statistics

-   **Endpoint:** `GET /api/statistics/products`
-   **Description:** Retrieves detailed statistics about products.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "data": {
        "total_products": 10,
        "active_products": 8,
        "inactive_products": 2,
        "average_price": 299.99,
        "highest_price": 999.99,
        "lowest_price": 49.99,
        "total_stock": 500,
        "out_of_stock_products": 2,
        "low_stock_products": 3,
        "total_stock_value": 15000.00
    }
}
```

### 3. Stock Statistics

-   **Endpoint:** `GET /api/statistics/stock`
-   **Description:** Retrieves inventory and stock-related statistics.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "data": {
        "total_products": 10,
        "out_of_stock_products": 2,
        "low_stock_products": 3,
        "adequate_stock_products": 5,
        "total_stock": 500,
        "total_stock_value": 15000.00,
        "critical_products": [
            {
                "id": 1,
                "name": "Product Name",
                "current_stock": 0,
                "price": 299.99,
                "stock_value": 0.00,
                "status": "out_of_stock"
            }
        ]
    }
}
```

### 4. Pricing Statistics

-   **Endpoint:** `GET /api/statistics/pricing`
-   **Description:** Retrieves pricing-related statistics and distribution.
-   **Authentication:** Required
-   **Response Schema:**

```json
{
    "data": {
        "total_products": 10,
        "average_price": 299.99,
        "median_price": 250.00,
        "highest_price": 999.99,
        "lowest_price": 49.99,
        "price_range": 950.00,
        "total_inventory_value": 15000.00,
        "price_distribution": {
            "under_50": 1,
            "50_to_100": 2,
            "100_to_250": 3,
            "250_to_500": 3,
            "over_500": 1
        }
    }
}
```

---

## Base URL

The base URL for all API endpoints is: `http://localhost:8000/api`

## Rate Limiting

API endpoints may be subject to rate limiting. Check response headers for rate limit information.
