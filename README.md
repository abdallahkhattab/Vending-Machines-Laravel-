Employee Purchase System
A Laravel-based application for managing employee purchases through vending machines using NFC/RFID cards. The system includes a Filament admin panel for management, an API for vending machine integration, and automated daily balance recharges. It tracks employee consumption limits by category (juice, meal, snack) and provides comprehensive reporting.
Features

Employee Management: Manage employees with classifications, NFC/RFID card assignments, and status tracking.
Vending Machine Management: Configure vending machines and their slots with products (juice, meal, snack) and prices.
Purchase API: Process purchases via API with validation for card number, machine, slot, and price.
Daily Balance Recharge: Automatically recharge employee balances daily based on classification limits.
Category-based Limits: Enforce daily limits for juice, meal, and snack purchases per employee classification.
Transaction Logging: Log all purchase attempts (success or failure) for auditing and reporting.
Filament Admin Panel: User-friendly interface for managing resources, viewing reports, and recharging balances.
Real-time Statistics: Dashboard widget showing active employees, vending machines, and daily transaction stats.
Automated Console Command: Schedule daily balance recharges using Laravel's task scheduler.
Role-based Access Control: Secure admin panel access with Filament's authentication.

Tech Stack

Backend: Laravel 11.x, PHP 8.2+
Frontend (Admin): Filament 3.x, Livewire, Tailwind CSS
Database: MySQL/MariaDB
Dependencies: Composer for package management
API: RESTful endpoints for vending machine integration

Installation
Prerequisites

PHP 8.2 or higher
Composer
MySQL/MariaDB
Node.js and NPM (for Filament assets)
Git

Steps

Clone the Repository
git clone https://github.com/your-username/employee-purchase-system.git
cd employee-purchase-system


Install Dependencies
composer install
npm install && npm run build


Set Up Environment
Copy the .env.example file to .env and configure your database and application settings:
cp .env.example .env

Update the following in .env:
APP_URL=http://localhost:8000
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=employee_purchase_system
DB_USERNAME=your_username
DB_PASSWORD=your_password

Generate an application key:
php artisan key:generate


Run Migrations and Seed Database
php artisan migrate
php artisan db:seed

This creates the necessary tables and populates them with sample data (classifications, employees, vending machines, slots).

Create Admin User
php artisan make:filament-user

Follow the prompts to create a user for the Filament admin panel.

Set Up Task Scheduler
To enable daily balance recharges, add the Laravel scheduler to your server's cron jobs:
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1


Start Development Server
php artisan serve

Access the application at http://localhost:8000 and the admin panel at http://localhost:8000/admin.


API Documentation
Endpoints
1. Process a Purchase

URL: /api/v1/purchase

Method: POST

Content-Type: application/json

Body:
{
    "user_id": "CARD001",
    "machine_id": 1,
    "slot_number": 5,
    "product_price": 50
}


Response (Success):
{
    "success": true,
    "message": "Purchase successful",
    "remaining_balance": 450,
    "product_dispensed": "Juice Product 5"
}


Response (Failure):
{
    "success": false,
    "message": "Invalid card number or inactive employee"
}



2. Get Employee Balance

URL: /api/v1/employee/balance

Method: POST

Content-Type: application/json

Body:
{
    "card_number": "CARD001"
}


Response (Success):
{
    "success": true,
    "data": {
        "employee_name": "John Manager",
        "current_balance": 500,
        "classification": "Manager",
        "today_consumption": {
            "juice_count": 0,
            "meal_count": 0,
            "snack_count": 0,
            "points_used": 0
        },
        "limits": {
            "daily_juice_limit": 3,
            "daily_meal_limit": 2,
            "daily_snack_limit": 2,
            "daily_point_limit": 500
        }
    }
}


Response (Failure):
{
    "success": false,
    "message": "Employee not found"
}



Testing API
Use tools like Postman or cURL to test the API endpoints. Example cURL command for a purchase:
curl -X POST http://localhost:8000/api/v1/purchase \
-H "Content-Type: application/json" \
-d '{
    "user_id": "CARD001",
    "machine_id": 1,
    "slot_number": 5,
    "product_price": 50
}'

Admin Panel

URL: /admin

Features:

Manage classifications, employees, vending machines, and slots.
View transaction history with filters for status, employee, machine, and date range.
Recharge individual or all active employee balances.
Real-time statistics widget for employees, machines, and daily transactions.


Access: Log in with the credentials created during php artisan make:filament-user.


Console Commands

Recharge Employee Balances:
php artisan employees:recharge

This command recharges all active employees' balances based on their classification's daily point limit. It runs automatically daily at midnight via the scheduler.


Database Schema

classifications: Defines employee categories with daily limits for juice, meals, snacks, and points.
employees: Stores employee details (name, card number, classification, balance, status).
vending_machines: Tracks machine locations and status.
slots: Configures machine slots with product categories, prices, and names.
transactions: Logs all purchase attempts with employee, machine, slot, status, and failure reasons.
daily_consumption: Tracks daily consumption per employee by category and points.

Seeder
The DatabaseSeeder populates the database with:

3 classifications (Manager, Regular Employee, Supervisor).
3 sample employees with unique card numbers.
2 vending machines with 40 slots each (10 juices, 20 meals, 10 snacks).

Run php artisan db:seed to apply the seeder.
Troubleshooting

Integrity Constraint Violation: Ensure migrations are applied correctly. If you encounter errors like Column 'employee_id' cannot be null, verify that the transactions table has employee_id and slot_id set as nullable (see migration 2025_06_23_000007_alter_transactions_table.php).
Filament Assets Not Loading: Run npm run build to compile assets.
Scheduler Not Running: Check cron job configuration and ensure php artisan schedule:run works manually.
API Errors: Enable Laravel's debug mode (APP_DEBUG=true in .env) for detailed error messages.

Contributing

Fork the repository.
Create a feature branch (git checkout -b feature/your-feature).
Commit your changes (git commit -m 'Add your feature').
Push to the branch (git push origin feature/your-feature).
Open a pull request.

License
This project is licensed under the MIT License. See the LICENSE file for details.
Contact
For issues or questions, please open an issue on GitHub or contact the maintainer at [your-email@example.com].