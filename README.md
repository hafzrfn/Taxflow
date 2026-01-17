# TaxFlow

<p align="center">
  <img src="public/images/taxflow-logo.png" alt="TaxFlow Logo" width="300">
</p>

<p align="center">
  <strong>A Modern Indonesian Tax Management System</strong>
</p>

<p align="center">
  <a href="#-features">Features</a> •
  <a href="#-tech-stack">Tech Stack</a> •
  <a href="#-prerequisites">Prerequisites</a> •
  <a href="#-installation">Installation</a> •
  <a href="#-running-the-application">Running</a> •
  <a href="#-license">License</a>
</p>

---

## 📋 About TaxFlow

**TaxFlow** is a comprehensive tax management system designed for Indonesian citizens to easily manage their tax obligations. The platform provides a user-friendly interface for registering tax data, viewing tax bills, filing tax returns, and making online payments.

### Key Capabilities
- 👤 User registration and authentication
- 📊 Tax object management (Objek Pajak)
- 📄 Tax return filing (SPT - Surat Pemberitahuan)
- 💰 Tax bill tracking and payment
- 🔐 Admin dashboard for oversight
- 🔔 Email notifications
- 💳 Payment gateway integration

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Laravel Blade Templates, Tailwind CSS 3, Alpine.js |
| **Database** | MySQL/PostgreSQL (SQLite for development) |
| **Build Tool** | Vite |
| **Testing** | PHPUnit |
| **Package Management** | Composer (PHP), NPM (JavaScript) |

---

## ✅ Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2 or higher** - [Download PHP](https://www.php.net/downloads)
- **Composer** - [Download Composer](https://getcomposer.org/)
- **Node.js 16+** - [Download Node.js](https://nodejs.org/)
- **MySQL 8.0+** or **PostgreSQL 13+** - [Download MySQL](https://www.mysql.com/downloads/) or [PostgreSQL](https://www.postgresql.org/download/)
- **Git** - [Download Git](https://git-scm.com/)

### System Requirements
- 2GB RAM minimum
- 500MB free disk space
- Windows, macOS, or Linux

---

## 🚀 Installation

### Step 1: Clone the Repository

```bash
git clone https://github.com/yourusername/taxflow.git
cd taxflow
```

### Step 2: Install PHP Dependencies

```bash
composer install
```

### Step 3: Install JavaScript Dependencies

```bash
npm install
```

### Step 4: Setup Environment Variables

Copy the example environment file and configure it:

```bash
cp .env.example .env
```

Edit the `.env` file with your database and application details:

```env
APP_NAME=TaxFlow
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=taxflow
DB_USERNAME=root
DB_PASSWORD=your_database_password

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@taxflow.local
```

### Step 5: Generate Application Key

```bash
php artisan key:generate
```

### Step 6: Create Database

Create a new database for TaxFlow:

**For MySQL:**
```sql
CREATE DATABASE taxflow;
```

**For PostgreSQL:**
```sql
CREATE DATABASE taxflow;
```

### Step 7: Run Database Migrations

```bash
php artisan migrate
```

### Step 8: Seed the Database (Optional)

Populate the database with sample data:

```bash
php artisan db:seed
```

### Step 9: Build Frontend Assets

```bash
npm run build
```

---

## ▶️ Running the Application

### Start Development Server

In one terminal, run the Laravel development server:

```bash
php artisan serve
```

This starts the server at `http://localhost:8000`

### Start Frontend Build in Watch Mode

In another terminal, watch for frontend changes:

```bash
npm run dev
```

### Access the Application

Open your browser and navigate to:
```
http://localhost:8000
```

---

## 📁 Project Structure

```
taxflow/
├── app/
│   ├── Http/
│   │   ├── Controllers/      # Application controllers
│   │   ├── Middleware/       # HTTP middleware
│   │   └── Requests/         # Form validation requests
│   ├── Models/               # Eloquent models
│   │   ├── User.php
│   │   ├── WajibPajak.php
│   │   ├── ObjekPajak.php
│   │   ├── SPT.php
│   │   ├── Pembayaran.php
│   │   ├── TagihanPajak.php
│   │   └── ...
│   ├── Jobs/                 # Queued jobs
│   └── Services/             # Business logic services
├── database/
│   ├── migrations/           # Database schema
│   ├── seeders/              # Database seeders
│   └── factories/            # Model factories for testing
├── resources/
│   ├── views/                # Blade templates
│   ├── css/                  # Tailwind CSS
│   └── js/                   # Alpine.js components
├── routes/
│   ├── web.php               # Web routes
│   └── auth.php              # Authentication routes
├── public/
│   ├── images/               # Static images
│   └── build/                # Compiled assets
└── tests/                    # PHPUnit tests
```

---

## 🎯 Core Features

### 1. User Management
- User registration and login
- Profile management
- Dual-role system (User/Admin)

### 2. Tax Data Management
- Register and manage tax objects (Objek Pajak)
- Track tax obligations
- View tax billing information

### 3. Tax Returns (SPT)
- File tax returns
- Track submission history
- View submission status

### 4. Payment Processing
- View tax bills and payment status
- Process online payments
- Payment history and receipts

### 5. Admin Dashboard
- User management
- Manual verification of tax data
- Payment reconciliation
- Audit logging

---

## 🧪 Testing

Run the test suite:

```bash
php artisan test
```

Run tests with coverage:

```bash
php artisan test --coverage
```

---

## 🔧 Common Commands

```bash
# Create new model with migration
php artisan make:model ModelName -m

# Create new controller
php artisan make:controller ControllerName

# Create new migration
php artisan make:migration migration_name

# Run migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Clear application cache
php artisan cache:clear

# Queue listener (process jobs)
php artisan queue:listen

# Generate API documentation
php artisan tinker
```

---

## 📧 Email Configuration

By default, emails are logged. To enable actual email sending, update `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=ssl
```

---

## 📦 Deployment

### Prerequisites for Deployment
- Web server (Apache/Nginx)
- PHP 8.2+ installed on server
- MySQL/PostgreSQL database
- SSH access to server

### Deployment Steps

1. Clone repository on server
2. Install dependencies: `composer install --no-dev`
3. Install Node packages: `npm install`
4. Build assets: `npm run build`
5. Copy `.env.example` to `.env` and configure
6. Generate key: `php artisan key:generate`
7. Run migrations: `php artisan migrate --force`
8. Set permissions: `chmod -R 775 storage bootstrap/cache`
9. Configure web server to point to `public` directory

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

---

## 📄 License

This project is open-sourced software licensed under the [MIT license](LICENSE).

---

## 🆘 Support

For issues and questions:
- Open an issue on [GitHub Issues](https://github.com/yourusername/taxflow/issues)
- Check existing documentation in the `TUTORIAL` folder

---

## 👥 Authors

TaxFlow is built with ❤️ for the Indonesian taxpayer community.

---

**Last Updated:** January 2026
