# [ONGOING] Mini Point of Sale System 

A mini **Point of Sale (POS) system** built with **Laravel** for managing products, sales, and transaction records.

## Features

* **Product Management**

  * Create, update, and delete products
  * Search for products
  * Filter products by category

* **Checkout**

  * Add products to a transaction
  * Calculate the total amount in real time
  * Process sales

* **Transaction History**

  * View previous transactions
  * View details of past sales

* **Dashboard**

  * View daily sales
  * View daily profit
  * Display sales data using a graph

* **Authentication & Authorization**

  * User authentication using Laravel Starter Kit
  * User access control and authorization

## Technologies Used

* **Laravel**
* **PHP**
* **MySQL**
* **Blade**
* **Tailwind CSS**
* **JavaScript**
* **Chart.js**
* **Docker**

## What I Learned

While building this project, I practiced:

* CRUD operations
* Database querying
* Authentication
* Authorization
* Relational database management
* Real-time calculations with JavaScript
* Data visualization
* Laravel project deployment
* Docker setup and database migration

## Project Purpose

This project was built as a learning project to gain practical experience with **Laravel backend development**, database operations, authentication, authorization, and deploying a web application.


## Installation

### 1. Clone the repository

```bash
git clone <repository-url>
cd <project-folder>
```

### 2. Install dependencies

```bash
composer install
npm install
```

### 3. Configure the environment

Create the `.env` file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 4. Set up the database

This project uses **SQLite**.

If the SQLite database file does not already exist, create it:

```bash
touch database/database.sqlite
```

Then run the migrations:

```bash
php artisan migrate
```

### 5. Start the application

Start the Laravel development server:

```bash
php artisan serve
```

In another terminal, start the Vite development server:

```bash
npm run dev
```

The application will be available at the local address provided by Laravel.

