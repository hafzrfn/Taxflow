# TaxFlow

<p align="center">
  <img src="public/images/taxflow-logo.png" alt="TaxFlow Logo" width="300">
</p>

<p align="center">
  <strong>A Modern Indonesian Tax Management System</strong>
</p>
---

## About TaxFlow

**TaxFlow** is a comprehensive tax management system designed for Indonesian citizens to easily manage their tax obligations. The platform provides a user-friendly interface for registering tax data, viewing tax bills, filing tax returns, and making online payments.

### Key Capabilities
- User registration and authentication
- Tax object management (Objek Pajak)
- Tax return filing (SPT - Surat Pemberitahuan)
- Tax bill tracking and payment
- Admin dashboard for oversight
- MOCKUPPayment gateway integration

---

## 🛠️ Tech Stack

| Component | Technology |
|-----------|-----------|
| **Backend Framework** | Laravel 12 (PHP 8.2+) |
| **Frontend** | Laravel Blade Templates, Tailwind CSS 3, Alpine.js |
| **Database** | MySQL  |
| **Build Tool** | Vite |
| **Testing** | PHPUnit |
| **Package Management** | Composer (PHP), NPM (JavaScript) |

---

## ✅ Prerequisites

You need these in order to run the project:

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
