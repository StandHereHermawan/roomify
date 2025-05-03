# Laravel Application Setup

This guide will walk you through the steps to run a Laravel application with PHP 8.2 and Composer.

## Requirements

Before you begin, make sure your system has the following:

- **Docker** (for containerized environments)
- **PHP 8.2** (required for Laravel)
- **Composer** (PHP dependency manager)

### Install Dependencies

1. **Install PHP 8.2**  
   Follow the instructions from [PHP official documentation](https://www.php.net/manual/en/install.php) to install PHP 8.2 on your system.

2. **Install Composer**  
   You can install Composer globally by following the [installation guide](https://getcomposer.org/download/) from the Composer website.

3. **Install Docker** (if using Docker environment)  
   Docker is required for containerization. Follow the installation instructions for your OS on the [official Docker website](https://www.docker.com/get-started).

## Step-by-Step Setup

### 1. Clone the Laravel Repository

Clone your Laravel project to your local machine:

```bash
git clone git@github.com:StandHereHermawan/roomify.git
cd roomify
````

### 2. Set Up Environment Variables

Create a `.env` file in the root directory of your Laravel project. You can copy the default `.env.example`:

```bash
cp .env.example .env
```

Open `.env` and adjust the following settings to match your environment:

* **Database**:

  ```env
  DB_CONNECTION=mysql
  DB_HOST=127.0.0.1
  DB_PORT=3306
  DB_DATABASE=your_database
  DB_USERNAME=your_username
  DB_PASSWORD=your_password
  ```

* **App Configuration**:

  ```env
  APP_NAME=Laravel
  APP_ENV=local
  APP_KEY=base64:random_generated_key
  APP_DEBUG=true
  APP_URL=http://localhost
  ```

### 3. Install PHP Dependencies

Run the following command to install PHP dependencies using Composer:

```bash
composer install
```

### 4. Set Up Docker (Optional)

If you're using Docker for development, ensure that your `compose.yml` file is configured correctly. Then, start the containers:

```bash
docker-compose up -d
```

This will build and start the containers, including the MySQL database and Laravel application.

### 5. Generate Application Key

Generate the application key, which is used for session and encryption:

```bash
php artisan key:generate
```

### 6. Migrate Database

Run the database migrations to set up your database schema:

```bash
php artisan migrate
```

If you need to seed the database with sample data:

```bash
php artisan db:seed
```

### 7. Run the Laravel Application

Start the Laravel development server:

```bash
php artisan serve
```
