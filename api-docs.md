# API Documentation

This document provides a detailed description of the API endpoints, including request parameters and response schemas.

## Authentication

All API endpoints require token-based authentication using Laravel Sanctum. To authenticate your requests, you need to include an `Authorization` header with a bearer token.

`Authorization: Bearer <your-token>`

You can generate a token using the `php artisan auth:create-token` command.

---

## Students

### 1. Get all students

-   **Endpoint:** `GET /api/students`
-   **Description:** Retrieves a list of all students.
-   **Request Parameters:** None
-   **Response Schema:**

```json
{
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "student_id": "12345",
            "class": "10",
            "section": "A",
            "photo": "https://via.placeholder.com/150",
            "created_at": "2025-11-15T12:00:00.000000Z",
            "updated_at": "2025-11-15T12:00:00.000000Z"
        }
    ]
}
```

### 2. Create a new student

-   **Endpoint:** `POST /api/students`
-   **Description:** Creates a new student.
-   **Request Parameters:**

| Parameter    | Type   | Description              |
| ------------ | ------ | ------------------------ |
| `name`       | string | The name of the student. |
| `student_id` | string | The ID of the student.   |
| `class`      | string | The class of the student.  |
| `section`    | string | The section of the student.|
| `photo`      | string | (Optional) A URL to the student's photo. |

-   **Response Schema:**

```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "student_id": "12345",
        "class": "10",
        "section": "A",
        "photo": "https://via.placeholder.com/150",
        "created_at": "2025-11-15T12:00:00.000000Z",
        "updated_at": "2025-11-15T12:00:00.000000Z"
    }
}
```

### 3. Get a single student

-   **Endpoint:** `GET /api/students/{id}`
-   **Description:** Retrieves a single student by their ID.
-   **Request Parameters:** None
-   **Response Schema:**

```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "student_id": "12345",
        "class": "10",
        "section": "A",
        "photo": "https://via.placeholder.com/150",
        "created_at": "2025-11-15T12:00:00.000000Z",
        "updated_at": "2025-11-15T12:00:00.000000Z"
    }
}
```

### 4. Update a student

-   **Endpoint:** `PUT /api/students/{id}`
-   **Description:** Updates a student's information.
-   **Request Parameters:**

| Parameter    | Type   | Description              |
| ------------ | ------ | ------------------------ |
| `name`       | string | The name of the student. |
| `student_id` | string | The ID of the student.   |
| `class`      | string | The class of the student.  |
| `section`    | string | The section of the student.|
| `photo`      | string | (Optional) A URL to the student's photo. |

-   **Response Schema:**

```json
{
    "data": {
        "id": 1,
        "name": "John Doe",
        "student_id": "12345",
        "class": "10",
        "section": "A",
        "photo": "https://via.placeholder.com/150",
        "created_at": "2025-11-15T12:00:00.000000Z",
        "updated_at": "2025-11-15T12:00:00.000000Z"
    }
}
```

### 5. Delete a student

-   **Endpoint:** `DELETE /api/students/{id}`
-   **Description:** Deletes a student.
-   **Request Parameters:** None
-   **Response:** `204 No Content`

---

## Attendance

### 1. Record attendance in bulk

-   **Endpoint:** `POST /api/attendance`
-   **Description:** Records attendance for multiple students at once.
-   **Request Body:** An array of attendance objects.

```json
[
    {
        "student_id": 1,
        "date": "2025-11-15",
        "status": "present",
        "note": "Optional note"
    },
    {
        "student_id": 2,
        "date": "2025-11-15",
        "status": "absent",
        "note": "Optional note"
    }
]
```

-   **Response:**

```json
{
    "message": "Attendance recorded successfully."
}
```

### 2. Get monthly attendance report

-   **Endpoint:** `GET /api/attendance/report`
-   **Description:** Retrieves a monthly attendance report for a specific class.
-   **Request Parameters:**

| Parameter | Type    | Description              |
| --------- | ------- | ------------------------ |
| `month`   | integer | The month of the report (1-12). |
| `class`   | string  | The class to generate the report for. |

-   **Response Schema:**

```json
[
    {
        "id": 1,
        "student_id": 1,
        "date": "2025-11-15",
        "status": "present",
        "note": null,
        "recorded_by": 1,
        "created_at": "2025-11-15T12:00:00.000000Z",
        "updated_at": "2025-11-15T12:00:00.000000Z",
        "student": {
            "id": 1,
            "name": "John Doe",
            "student_id": "12345",
            "class": "10",
            "section": "A",
            "photo": "https://via.placeholder.com/150",
            "created_at": "2025-11-15T12:00:00.000000Z",
            "updated_at": "2025-11-15T12:00:00.000000Z"
        }
    }
]
```

### 3. Get attendance statistics

-   **Endpoint:** `GET /api/attendance/statistics`
-   **Description:** Retrieves attendance statistics.
-   **Request Parameters:** None
-   **Response Schema:**

```json
{
    "present": 100,
    "absent": 10,
    "late": 5
}
```
