
# Attendance Management System

This is a Laravel-based attendance management system that provides a robust API for managing students, recording attendance, and generating insightful reports and statistics. It's designed to be a backend powerhouse for any modern attendance tracking application.

## Features

- **Student Management:** CRUD operations for students.
- **Attendance Tracking:** Record daily attendance (present, absent, late).
- **Reporting:** Generate monthly attendance reports.
- **Statistics:** Get attendance statistics and trends.
- **Authentication:** Secure API endpoints with Laravel Sanctum.
- **Scalable:** Built on the latest Laravel 12 for a modern, scalable, and maintainable codebase.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 8.2
- Composer
- A database server (SQLite, MySQL, PostgreSQL, etc.)

### Installation

1. **Clone the repository:**
   ```bash
   git clone https://github.com/hannanmiah/attendance-management-backend.git
   cd attendance-management-backend
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

All endpoints are prefixed with `/api`.

### Authentication

- **`POST /auth/register`**: Register a new user.
  - **Parameters:**
    - `name` (string, required)
    - `email` (string, required, unique)
    - `password` (string, required, min:8, confirmed)
  - **Response:** `201 Created` with a Sanctum token.

- **`POST /auth/login`**: Log in a user.
  - **Parameters:**
    - `email` (string, required, email)
    - `password` (string, required, min:8)
  - **Response:** `200 OK` with a Sanctum token.

- **`POST /auth/logout`**: Log out the authenticated user.
  - **Authentication:** Required.
  - **Response:** `204 No Content`.

### Students

- **`GET /students`**: Get a paginated list of students.
  - **Authentication:** Required.
  - **Query Parameters:**
    - `per_page` (integer, optional): Number of students per page.
    - `search` (string, optional): Search by name, class, or section.
    - `class` (string, optional): Filter by class.
    - `student_id` (string, optional): Filter by student ID.
  - **Response:** `200 OK` with a paginated list of students.

- **`POST /students`**: Create a new student.
  - **Authentication:** Required.
  - **Parameters:**
    - `name` (string, required, max:255)
    - `student_id` (string, required, max:255, unique)
    - `class` (string, required, max:255)
    - `section` (string, required, max:255)
    - `photo` (string, nullable, max:255)
  - **Response:** `201 Created` with the new student data.

- **`GET /students/{student}`**: Get a specific student.
  - **Authentication:** Required.
  - **Response:** `200 OK` with the student data.

- **`PUT/PATCH /students/{student}`**: Update a student.
  - **Authentication:** Required.
  - **Parameters:** Same as `POST /students`.
  - **Response:** `200 OK` with the updated student data.

- **`DELETE /students/{student}`**: Delete a student.
  - **Authentication:** Required.
  - **Response:** `204 No Content`.

### Attendance

- **`GET /attendances`**: Get a paginated list of attendance records.
  - **Authentication:** Required.
  - **Query Parameters:**
    - `per_page` (integer, optional): Number of records per page.
  - **Response:** `200 OK` with a paginated list of attendance records.

- **`POST /attendance`**: Record attendance for one or more students.
  - **Authentication:** Required.
  - **Parameters:** An array of attendance objects:
    ```json
    [
      {
        "student_id": 1,
        "date": "2025-11-16",
        "status": "present",
        "note": "Arrived on time."
      },
      {
        "student_id": 2,
        "date": "2025-11-16",
        "status": "absent",
        "note": "Sick leave."
      }
    ]
    ```
  - **Response:** `200 OK` with a success message.

- **`GET /attendance/report`**: Get a monthly attendance report.
  - **Authentication:** Required.
  - **Query Parameters:**
    - `month` (integer, required, between:1,12)
    - `class` (string, required)
  - **Response:** `200 OK` with the monthly report data.

- **`GET /attendance/statistics`**: Get attendance statistics.
  - **Authentication:** Required.
  - **Response:** `200 OK` with attendance statistics.

### Statistics

- **`GET /stats/attendance-this-month`**: Get daily attendance trend for the current month.
  - **Authentication:** Required.
  - **Response:** `200 OK` with the trend data.

- **`GET /stats/attendance-this-year`**: Get monthly attendance trend for the current year.
  - **Authentication:** Required.
  - **Response:** `200 OK` with the trend data.

### More api docs
- [API Docs](api-docs.md)

## Testing

To run the test suite, use the following command:

```bash
php artisan test
```

## Built With

- [Laravel](https://laravel.com/) - The PHP framework for web artisans.
- [Laravel Sanctum](https://laravel.com/docs/sanctum) - For API authentication.
- [Laravel Trend](https://github.com/flowframe/laravel-trend) - For generating trends.
- [Pest](https://pestphp.com/) - The elegant PHP testing framework.

## Contributing

Thank you for considering contributing to the Attendance Management System! Please feel free to create a pull request.

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
