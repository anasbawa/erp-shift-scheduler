<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

# ERP Shift Scheduler

A web-based Enterprise Resource Planning (ERP) system for efficient shift scheduling and management, built with Laravel.

## Features

ERP Shift Scheduler is a comprehensive solution designed to streamline the process of managing employee shifts, schedules, and workforce planning. Key features include:
- Employee shift management
- Automated scheduling
- Conflict detection and resolution
- Cron Jobs For Releasing Expired Requests

## Requirements

- PHP >= 8.1
- Composer
- MySQL
- Laravel 11.x
- Web Server (Apache/Nginx)

## Installation

1. Clone the repository
git clone https://github.com/anasbawa/erp-shift-scheduler.git

2. Navigate to project directory
cd erp-shift-scheduler

3. Install PHP dependencies
composer install

4. Create environment file
copy .env.example .env

5. Generate application key
php artisan key:generate

6. Configure database connection in .env file
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=erp_shift_scheduler
DB_USERNAME=your_username
DB_PASSWORD=your_password

7. Run database migrations and seeders
php artisan migrate --seed

8. Run test suite
php artisan test --filter=FullShiftRequestFlowTest

9. Start the development server
php artisan serve

