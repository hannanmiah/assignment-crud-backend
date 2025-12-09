Based on the technical assessment email, here are the step-by-step requirements for the backend codebase (Laravel):

### Laravel Backend Requirements (60%)

#### **1. Student Management**

* **Model:** Create a `Student` model with the following attributes: `name`, `student_id`, `class`, `section`, and `photo`.
* **CRUD:** Implement Create, Read, Update, and Delete (CRUD) endpoints.
* **Validation:** Ensure all CRUD endpoints have proper data validation.
* **API Responses:** Use Laravel Resource for all API responses.

#### **2. Attendance Module**

* **Model:** Create an `Attendance` model with the following attributes: `student_id`, `date`, `status`, `note`, and `recorded_by`.
* **Bulk Recording:** Implement a single endpoint for recording attendance in bulk.
* **Query Optimization:** Optimize database queries for attendance reports.
* **Monthly Report:** Generate a monthly attendance report, ensuring the use of eager loading to optimize data fetching.

#### **3. Advanced Features**

* **Service Layer:** Implement a Service Layer to encapsulate and manage attendance business logic.
* **Artisan Command:** Create a custom Artisan command with the signature `attendance:generate-report {month} {class}`.
* **Events/Listeners:** Utilize Laravel Events and Listeners for attendance notifications.
* **Redis Caching:** Implement Redis caching for attendance statistics.

### **General Technical Requirements**

* **Framework Version:** Use Laravel 10+ (and Vue 3 for frontend).
* **Database:** Use MySQL or PostgreSQL with proper database migrations.
* **Authentication:** Implement simple token-based authentication using Laravel Sanctum.
* **Architecture:** Adhere to SOLID principles.
* **Testing:** Write a minimum of three unit tests for critical features.
* **Containerization:** Docker setup is optional but recommended.
* **Git:** Maintain a clean Git history with meaningful commits.


# AI Workflow

## 1. AI Prompt

```markdown
  - Laravel 12
  - MySQL or PostgreSQL
  - Laravel Sanctum
  - SOLID principles
  - Write tests
  - Clean Git history with meaningful commits

write a Laravel backend codebase for the above requirements. add model, migrations, controller, routes, and tests.
add laravel sanctum for spa authentication.
add service or dependency pattern for logic segregation.
add redis caching for statistics.
add artisan command for attendance report generation.
add event and listener for attendance notifications.
```