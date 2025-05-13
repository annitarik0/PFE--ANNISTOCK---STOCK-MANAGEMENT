# ANNISTOCK - Stock Management System

A comprehensive stock management system built with Laravel.

## Technologies Used

- **PHP** - The primary backend programming language
- **Laravel** - PHP framework used for the application structure, routing, and MVC architecture
- **Eloquent ORM** - Laravel's database ORM for database interactions
- **Blade** - Laravel's templating engine for views
- **HTML5** - For markup structure
- **CSS3** - For styling
- **JavaScript** - For client-side functionality
- **jQuery** - JavaScript library for DOM manipulation
- **Bootstrap** - CSS framework for responsive design
- **Chart.js** - JavaScript library for creating interactive charts and data visualizations
- **Material Design Icons (MDI)** - Icon library

## Setup Instructions

1. Clone the repository
2. Run `composer install`
3. Copy `.env.example` to `.env` and configure your database settings
4. Run `php artisan key:generate`
5. Run `php artisan migrate`
6. Run `php artisan serve` to start the development server

## Available Artisan Commands

The following custom Artisan commands are available to help with development and maintenance:

### Create Admin User

```
php artisan app:create-admin [--force]
```

Creates an admin user with the following credentials:
- Email: admin@gmail.com
- Password: 123456

Options:
- `--force`: Force creation even if it means deleting existing users

### Create Test Data

```
php artisan app:create-test-data
```

Creates sample categories and products for testing purposes.

### Fix Database Tables

```
php artisan app:fix-tables [table]
```

Fixes database table structure and data issues.

Arguments:
- `table`: Specific table to fix (categories, products, orders, order_items, users, all)

### Create Test Orders

```
php artisan app:create-test-order [user_id] [--count=1]
```

Creates test orders with random products.

Arguments:
- `user_id`: The ID of the user to create the order for (optional)

Options:
- `--count=1`: Number of orders to create (default: 1)

## User Roles

The system supports two user roles:

1. **Admin** - Full access to all features
2. **Employee** - Limited access to certain features

## Features

- User Management
- Product Management
- Category Management
- Order Management
- Dashboard with Analytics
- Search Functionality
- Notifications
- Profile Management

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
