```markdown
### POS System (POS_project_final)

A professional Point of Sale (POS) system built with the Laravel PHP framework, featuring robust inventory management, transaction tracking, and sales analytics.

---

## 🚀 Features

* **Inventory Management**: Track stock levels, products, and categories in real-time.
* **Sales Counter**: Intuitive interface for processing transactions quickly.
* **Data Logging**: Local database logging for all sales histories and user operations.
* **Authentication**: Secure role-based access control (Admin/Staff).

---

## 🛠️ Tech Stack

* **Framework**: Laravel (PHP)
* **Database**: MySQL / PostgreSQL (Local backup stored in `POS_project.sql`)
* **Frontend**: Blade Templates, Tailwind CSS / Vite
* **Package Manager**: Composer & NPM

---

## ⚙️ Getting Started & Installation

Follow these steps to set up and run this Laravel project locally on your machine.

### 1. Prerequisites

Make sure you have **PHP (8.1+)**, **Composer**, and **Node.js** installed on your Mac. You can check them by running:
```bash
php -v
composer -v
node -v
``` 

### 2. Clone the Repository
```bash
git clone [https://github.com/ChanMyaeKyaw1/POS_project.git](https://github.com/ChanMyaeKyaw1/POS_project_final.git)
cd POS_project_final
```

### 3. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node modules
npm install
```

### 4. Environment Configuration
```bash
cp .env.example .env
```

### 5. Generate Application Key
```bash
php artisan key:generate
```

### 6. Database Setup & Migration
```bash
php artisan migrate
```

### 7. Build Frontend Assets & Start the Servers

Terminal 1 (Compiles Assets):
```bash
npm run dev
```

Terminal 2 (Runs PHP Server):
```bash
php artisan serve
```

### Once both servers are running, open your web browser and navigate to:

Application Home: http://127.0.0.1:8000
