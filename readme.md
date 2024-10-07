# Laravel Backend Test Project

This project is a Laravel-based API that includes user authentication, package management, and registration features. It also provides an Artisan command for internal package registration by the sales team. The API is secured using Laravel Sanctum.

## Features

- **User Registration & Authentication**: Register new users and authenticate them via API endpoints.
- **Package Listing & Registration**: View available packages and register users for specific packages.
- **Token-Based Authentication**: Secure API endpoints using Laravel Sanctum.
- **Command-Line Package Registration**: Internal sales team can register customers for packages using an Artisan command.

## Installation

Follow these steps to set up the project on your local environment:

1. **Clone the repository**:
   ```bash
   git clone git@github.com:donat-ferati/backend-test.git
   ```

2. **Navigate to the project directory**:
   ```bash
   cd backend-test
   ```

3. **Install dependencies**:
   ```bash
   composer install
   ```

4. **Copy the `.env.example` file to `.env` and configure the environment variables**:
   ```bash
   cp .env.example .env
   ```

5. **Generate the application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run migrations and seed the database**:
   ```bash
   php artisan migrate --seed
   ```

7. **Set up Laravel Sanctum**:
   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

## API Endpoints

### User Registration
- **Endpoint**: `/api/register`
- **Method**: `POST`
- **Parameters**:
  - `name` (string, required)
  - `email` (string, required, unique)
  - `password` (string, required, min:8)
  - `password_confirmation` (string, required, must match password)
- **Response**:
  - 201 on success
  - 422 on validation error

### User Login
- **Endpoint**: `/api/login`
- **Method**: `POST`
- **Parameters**:
  - `email` (string, required)
  - `password` (string, required)
- **Response**:
  - 200 with token on success
  - 401 on invalid credentials

### List Packages
- **Endpoint**: `/api/packages`
- **Method**: `GET`
- **Response**:
  - 200 with a list of packages and their availability

### Register for a Package
- **Endpoint**: `/api/packages/register`
- **Method**: `POST`
- **Parameters**:
  - `customer_id` (integer, required)
  - `package_id` (integer, required)
- **Response**:
  - 201 on success
  - 422 on validation error or if package is unavailable

## Artisan Commands

### Register Package for a Customer
- **Command**: `php artisan register:package`
- **Description**: Register a package for an existing customer. You will be asked to provide `customer_id` and `package_id` as prompts.
  ```bash
  # Register a package interactively
  php artisan register:package
  ```

## Running Tests

_**To run tests for this project it works by simply writing the command bellow as is, this is  simply for convenience, `.env.testing` is required in a production / staging enviroment.**_

Run all tests with:
```bash
php artisan test
```

### Filter Through Specific Tests
```bash
php artisan test --filter=LoginControllerTest
```


### Test Coverage
- **User Registration and Login**: Tests for registering and logging in users and clients.
- **Package Listing and Registration**: Tests for viewing available packages and registering customers.
- **Test Statistics**: **36** _Assertions_, **8** _Tests_, **4** _Features_.

## Notes

- Make sure all environment variables are set up correctly.
- The application is designed for API usage only.

### Thank you for reviewing my Test Project!

-Sincerely Donat Ferati!
