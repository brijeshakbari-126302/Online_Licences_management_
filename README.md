# LicenseHub Pro &mdash; Enterprise Software Asset & License Management System

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![Database](https://img.shields.io/badge/Database-SQLite%20%7C%20MySQL-003B57?style=for-the-badge&logo=sqlite&logoColor=white)](https://sqlite.org)
[![Tests Status](https://img.shields.io/badge/Tests-26%20Passed%20(87%20assertions)-success?style=for-the-badge&logo=phpunit&logoColor=white)](tests/Feature)
[![Code Style](https://img.shields.io/badge/Code%20Style-Laravel%20Pint%20(PSR--12)-blueviolet?style=for-the-badge)](https://laravel.com/docs/pint)

**LicenseHub Pro** is a centralized, enterprise-grade **Software Asset & License Governance (SAM)** web application built with **Laravel 12 (PHP 8.3)**, **Blade templates**, a custom **Light Mode Design System**, and responsive **jQuery Form Validation**.

It enables IT leadership, asset managers, and finance teams to eliminate expensive unused software seats (*shelfware*), prevent unexpected contract expirations with 30-day urgency radars, track software allocations down to individual employee hardware device IDs, and export audit-ready compliance CSV reports.

---

## ⚡ Quick Links & Viva Preparation

> **🎓 Academic / Viva Voce Preparation:**  
> A dedicated preparation guide containing an executive pitch, database dictionary, 5-minute live demo script, and the **Top 30 Viva Questions & High-Scoring Answers** is available in [PREPARATION_GUIDE.md](PREPARATION_GUIDE.md).

---

## 🌟 Key Features & Modules

### 1. 📊 Executive License Dashboard (`/dashboard`)
- **Key Metrics Radar:** Real-time counts of active subscriptions, total seat capacity, staff count, and software publishers.
- **Financial Intelligence:** Automated calculation of normalized **Annual Software Spend** across monthly, annual, and perpetual agreements.
- **Seat Utilization Metric ($U\%$):** Visual percentage indicating software efficiency and flagging wasted shelfware spend.
- **30-Day Expiry Radar:** Proactive warning cards highlighting contracts requiring renewal within 30 days.

### 2. 🔑 Software License Inventory (`/licenses`)
- Full CRUD operations with search, vendor filtering, and category filters (Development, Design, Productivity, Cloud, Security).
- Tracks license keys, serials, seat allocation limits, billing cycles, purchase dates, and expiration dates.
- High-visibility status badges (`Active`, `Expiring Soon`, `Expired`, `Suspended`).

### 3. 👥 Seat Allocation & Device Governance (`/assignments`)
- Maps license seats directly to corporate employees and physical workstations/device serial numbers.
- **Capacity Guardrail:** Enforces hard limits preventing over-allocation when remaining seats reach zero.
- Historical tracking with revocation dates (`Active` vs `Revoked`) for publisher compliance audits.

### 4. 🏢 Software Vendor Directory (`/vendors`)
- Centralized publisher catalog (JetBrains, Microsoft, Adobe, Figma, Docker, etc.).
- Direct contact details, dedicated account manager info, phone numbers, and official vendor support URLs.

### 5. 🧑‍💼 Employee Staff Directory (`/employees`)
- Corporate employee roster with badge ID (`EMP-XXXX`), department, job title, and active license count.

### 6. 🔄 Contract Renewals Hub (`/renewals`)
- Proactive 30-day expiration alerts.
- **1-Click Contract Extension:** Instantly extends software agreements by **+1 Month** or **+1 Year** using Carbon date math, resetting status and updating the audit log.

### 7. 📈 Reports & Streamed CSV Export (`/reports`)
- Executive summary metrics and category allocation breakdowns.
- **Zero-Memory CSV Stream:** Streamed downloads (`/reports/export/licenses`, `/reports/export/assignments`, `/reports/export/renewals`) via `php://output` without memory overhead.

### 8. 🛡️ Immutable Audit Activity Trail (`/activity`)
- Chronological, filterable record of system events: seat allocations, contract renewals, license creations, and settings updates.

### 9. ⚙️ System Settings & Preferences (`/settings`)
- Persistent enterprise branding (company name, primary admin alert email, currency selector, renewal warning threshold).

### 10. 🌐 Public Website & Secure Authentication
- **Landing Page (`/`):** Enterprise hero section, feature highlights, and dynamic live metrics.
- **About Us (`/about`):** Architecture overview, transparency mission, and SLA guarantees.
- **Contact & Support (`/contact`):** Direct support headquarters info and interactive inquiry submission form.
- **Sign In (`/login`):** Modern authentication card with **1-Click Demo Credentials Auto-Fill** (`admin@licensehub.pro` / `password`).
- **Register (`/register`):** Account creation form with password confirmation.
- **Dedicated Logout Button:** Prominent logout controls in the top navigation bar and sidebar footer.

---

## 🎨 Frontend Design & Client-Side Validation

- **Modern Light Theme:** Built with pure Vanilla CSS and CSS Custom Properties (`public/css/app.css`). Clean surface cards, subtle borders, and zero external CSS framework bloat.
- **Suppressed Browser Tooltips (`novalidate`):** Completely eliminates browser-native popup balloons.
- **jQuery Validation Engine:** Real-time client-side evaluation powered by jQuery 3.7.1 and jQuery Validate (`public/js/form-validation.js`), featuring:
  - Custom SVG inline error badges.
  - Live feedback on `input`, `change`, and `blur`.
  - Micro-shake animation and smooth auto-scroll to the first invalid field.

---

## 🛠️ Technology Stack

| Component | Technology | Version | Purpose |
| :--- | :--- | :--- | :--- |
| **Backend** | PHP | 8.3.x | Core programming language |
| **Framework** | Laravel | 12.x | MVC web framework, routing, and ORM |
| **Database** | SQLite / MySQL | 3.x / 8.x | Relational database storage |
| **Templating** | Blade | Latest | Server-rendered view engine |
| **Styling** | Vanilla CSS | CSS3 | Custom token-based light design system |
| **Scripting** | jQuery + jQuery Validate | 3.7.1 / 1.20.0 | Client-side form validation and DOM interactions |
| **Testing** | PHPUnit | 11.5 | Automated feature and HTTP test suite |
| **Code Style** | Laravel Pint | 1.x | PSR-12 code style checker and fixer |

---

## 🚀 Installation & Local Setup

### Prerequisites
- PHP $\ge$ 8.2 (PHP 8.3 recommended)
- Composer $\ge$ 2.0
- Laragon, XAMPP, or PHP built-in CLI server
- Git

### 1. Clone the Repository
```bash
git clone https://github.com/brijeshakbari-126302/Online_Licences_management_.git
cd Online_Licences_management_
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Environment Configuration
```bash
cp .env.example .env
php artisan key:generate
```

### 4. Database Setup & Seeding
```bash
# Run migrations and seed sample vendors, licenses, employees, and demo admin
php artisan migrate --seed
```

### 5. Start the Development Server
```bash
php artisan serve
```
Open **[http://localhost:8000](http://localhost:8000)** in your browser.

---

## 🔑 Demo Credentials

| Role | Corporate Work Email | Password | Quick Action |
| :--- | :--- | :--- | :--- |
| **Super Administrator** | `admin@licensehub.pro` | `password` | Click **"Auto-fill"** on the `/login` page |

---

## 🧪 Automated Testing

The project includes **26 comprehensive Feature tests** validating all HTTP endpoints, session logic, authentication, form validations, and CSV streaming:

```bash
# Run the complete test suite
php artisan test --compact

# Run code style formatting check
vendor/bin/pint --test
```

```
Test Suite Execution Result:
✓ ExampleTest .............................. 1 passed
✓ LicenseManagementTest .................... 8 passed
✓ PendingPagesTest ......................... 6 passed
✓ PublicAndAuthPagesTest .................. 11 passed
Total: 26 passed (87 assertions)
```

---

## 📂 Project Structure

```
software-license-management/
├── app/
│   ├── Http/Controllers/
│   │   ├── ActivityLogController.php   # Audit trail and event filtering
│   │   ├── AssignmentController.php    # Seat allocation and capacity checks
│   │   ├── AuthController.php          # Login, Register, Logout
│   │   ├── DashboardController.php     # KPIs, spend math, expiry radar
│   │   ├── EmployeeController.php      # Staff roster management
│   │   ├── HomeController.php          # Public pages (Home, About, Contact)
│   │   ├── LicenseController.php       # License CRUD and inventory
│   │   ├── RenewalController.php       # 1-click contract extensions
│   │   ├── ReportController.php        # Analytics and streamed CSV exports
│   │   ├── SettingController.php       # Persistent enterprise preferences
│   │   └── VendorController.php        # Software publishers directory
│   └── Models/
│       ├── ActivityLog.php             # Audit log records
│       ├── Assignment.php              # Seat assignment pivot model
│       ├── ContactInquiry.php          # Public contact form inquiries
│       ├── Employee.php                # Corporate staff members
│       ├── License.php                 # Software license entity
│       ├── Setting.php                 # Key-value system settings
│       ├── User.php                    # Authenticated admin accounts
│       └── Vendor.php                  # Software vendors
├── database/
│   ├── migrations/                     # Schema definition files
│   └── seeders/DatabaseSeeder.php      # Test datasets and demo admin
├── public/
│   ├── css/app.css                     # Custom light design system
│   └── js/
│       ├── jquery.min.js               # jQuery library
│       ├── jquery.validate.min.js      # jQuery Validation Plugin
│       ├── additional-methods.min.js   # Extended validation rules
│       └── form-validation.js          # Project-wide validation engine
├── resources/views/                    # Blade presentation templates
├── routes/web.php                      # Application route declarations
├── tests/Feature/                      # PHPUnit feature test suite
├── PREPARATION_GUIDE.md                # Viva voce & exam defense guide
└── README.md                           # Master project documentation
```

---

## 📜 License & Acknowledgments

This project is open-source software licensed under the **[MIT License](LICENSE)**. Built for enterprise software governance and university engineering defense.
