Software License Management System
A web-based Software License Management System built with Laravel, Blade templates, and MySQL. The aim is to manage software licenses, vendors, employees, and license assignments in one place.
Project status: This README describes the intended project. Update the checklist and feature descriptions as you implement and test each module.

Table of Contents
- Overview
- Objectives
- Technology Stack
- Main Modules
- Suggested Database Design
- Project Structure
- Installation and Setup
- Run the Project
- Useful Commands
- Security Notes
- Future Enhancements
Overview
Organizations use many software products, each with its own license key, vendor, purchase date, expiry date, and permitted users or devices. Managing this information manually can lead to missed renewals, unused licenses, and compliance problems.

This project aims to provide a centralized web application for recording and tracking software licenses and their assignments.
Objectives
- Store and organize software license information.
- Track purchase and expiry dates.
- Manage software vendors and employee records.
- Assign licenses to employees and track assignments.
- Display a dashboard overview.
- Provide CRUD operations (Create, Read, Update, Delete) for supported modules.
- Make license information easier to search and maintain.
Technology Stack
Technology	Purpose
PHP	Backend programming language
Laravel	Web application framework
Blade	Server-rendered page templates
MySQL	Relational database
HTML and CSS	Page structure and styling
JavaScript	Optional client-side interactions
Laragon	Local development environment
Composer	PHP dependency management
VS Code	Code editor


Main Modules
1. Dashboard
- Overview of licenses, vendors, employees, and assignments.
- Space for expiry and renewal reminders as those features are implemented.
2. Software Licenses
- Add, view, edit, and delete license records.
- Record product name, license key, license type, purchase date, expiry date, cost, and status as appropriate.
3. Vendors
- Store software vendor information.
- Add, view, edit, and delete vendor records.
4. Employees
- Maintain employee records.
- Add, view, edit, and delete employee records.
5. License Assignments
- Record which license is assigned to which employee.
- Track assignment and return dates, where applicable.
The modules above describe the intended system. Keep this README aligned with the functionality that is actually implemented in your codebase.

Suggested Database Design
This is a suggested starting point. Your Laravel migration files in database/migrations/ are the source of truth for the actual schema.
licenses
- id — primary key
- vendor_id — related vendor, if used
- product_name — software product name
- license_key — license key or identifier; protect sensitive values
- license_type — individual, team, enterprise, etc.
- purchase_date — purchase date
- expiry_date — expiry date, if applicable
- cost — purchase or renewal cost
- status — active, expired, pending, etc.
vendors
- id — primary key
- name — vendor name
- email, phone, website — optional contact details
employees
- id — primary key
- name — employee name
- email, department — optional employee details
assignments
- id — primary key
- license_id — assigned license
- employee_id — employee receiving the license
- assigned_at — assignment date
- returned_at — return date, if applicable
Project Structure
Suggested structure for application-specific files. Keep Laravel's generated files and add your files as needed.
software-license-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── DashboardController.php
│   │   ├── LicenseController.php
│   │   ├── VendorController.php
│   │   ├── EmployeeController.php
│   │   └── AssignmentController.php
│   └── Models/
│       ├── License.php
│       ├── Vendor.php
│       ├── Employee.php
│       └── Assignment.php
├── database/migrations/
├── public/css/app.css
├── resources/views/
│   ├── layouts/app.blade.php
│   ├── partials/navbar.blade.php
│   ├── partials/sidebar.blade.php
│   ├── dashboard.blade.php
│   ├── licenses/
│   ├── vendors/
│   ├── employees/
│   └── assignments/
├── routes/web.php
├── .env.example
├── artisan
├── composer.json
└── README.md
Some listed files and folders may not exist yet. Create them as you build each module. Do not replace the Laravel-generated project structure wholesale.
Installation and Setup
Prerequisites
- PHP compatible with your installed Laravel version
- Composer
- MySQL
- Laragon or another local PHP/MySQL environment
- VS Code or another code editor
1. Open the project
Open your existing project folder in VS Code. In the terminal, change to the folder containing the artisan file.

Example:
cd C:\laragon\www\software-license-management
Change the path if your project is stored elsewhere.
2. Install PHP dependencies
composer install
3. Configure the environment
If .env does not exist and .env.example does, create a local copy:
copy .env.example .env
Set the database values in .env to match your local MySQL setup:
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=software_license_management
DB_USERNAME=root
DB_PASSWORD=
These example values assume a local MySQL root account with no password. Change them if your setup differs. Create the software_license_management database in Laragon's database tools or phpMyAdmin before running migrations.
4. Generate an application key
php artisan key:generate
Do not regenerate the key for an established deployment without understanding the impact on encrypted data and sessions.
5. Run database migrations
After creating the database and configuring .env:
php artisan config:clear
php artisan migrate
This runs migrations that already exist in the project. Create or update migrations if the required tables are not defined yet.
Run the Project
1. Open Laragon and click Start All.
2. In the VS Code terminal, navigate to the project root (the folder containing artisan).
3. Run:
   php artisan serve
4. Open the URL shown in the terminal, usually http://127.0.0.1:8000.
To use another port:
php artisan serve --port=8001
Then open http://127.0.0.1:8001.
Useful Commands
# Check Laravel version
php artisan --version

# List routes
php artisan route:list

# Create a resource controller
php artisan make:controller LicenseController --resource

# Create a model and migration
php artisan make:model License -m

# Clear cached configuration
php artisan config:clear

# Run database migrations
php artisan migrate

# Start the local development server
php artisan serve
Run the make:controller or make:model commands only if those files have not already been created.
Security Notes
- Do not commit .env or real credentials to GitHub.
- Keep .env.example free of real passwords and secret keys.
- Treat software license keys as sensitive; restrict access and avoid exposing them in logs or public pages.
- Validate submitted data on the server.
- Add authentication and authorization before protecting or deploying management features.
- Use CSRF protection for forms and escape output in Blade templates.
- Back up the database before destructive migrations or production changes.
Future Enhancements
- Expiry alerts and renewal reminders.
- Search, filtering, sorting, and pagination.
- License usage and availability reports.
- Role-based access for administrators and employees.
- Export reports to CSV or PDF.
- Audit history for changes and assignments.
- Email notifications for upcoming expirations.
Development Checklist
Update this checklist as you complete each feature.
- [ ] Laravel project runs locally.
- [ ] MySQL connection is configured.
- [ ] Database migrations are created and tested.
- [ ] Dashboard page is implemented.
- [ ] License CRUD is implemented.
- [ ] Vendor CRUD is implemented.
- [ ] Employee CRUD is implemented.
- [ ] License assignment workflow is implemented.
- [ ] Validation and authorization are tested.
- [ ] README reflects the final implementation.
Author
Add your name, class or department, institution, and project guide details here if required for submission.
