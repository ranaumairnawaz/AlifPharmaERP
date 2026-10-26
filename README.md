# 💊 Alif Pharma — Enterprise Pharmaceutical ERP & Inventory System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php" alt="PHP 8.2">
  <img src="https://img.shields.io/badge/Architecture-ERP%20%26%20Supply%20Chain-blue?style=for-the-badge" alt="ERP Architecture">
  <img src="https://img.shields.io/badge/Desktop%20Ready-Electron-47848F?style=for-the-badge&logo=electron" alt="Electron Desktop">
  <img src="https://img.shields.io/badge/Cloud%20Backups-AWS%20S3%20%26%20GDrive-orange?style=for-the-badge" alt="Cloud Backups">
</p>

---

## 📖 What is Alif Pharma?

**Alif Pharma** is a specialized, enterprise-grade **Pharmaceutical ERP (Enterprise Resource Planning), Supply Chain, and Warehouse Inventory Management Platform** engineered with **Laravel 12 & PHP 8.2+**.

Designed specifically for pharmaceutical distributors, medicine manufacturers, and healthcare wholesalers, Alif Pharma replaces disjointed spreadsheets with a unified ecosystem for batch expiry tracking, distributor invoicing, damage auditing, employee payroll, and automated cloud backups. It also includes an optional **Electron-powered desktop application wrapper** for warehouse terminals.

---

## 🎯 Why Alif Pharma? Problem & Solution

| The Challenge | How Alif Pharma Solves It |
| :--- | :--- |
| **Medicine Expiry Losses:** Pharmacies and distributors lose millions annually due to overlooked stock reaching expiry dates unnoticed on warehouse shelves. | Implements a **Granular Batch & Expiry Engine** tracking unique batch numbers, manufacturing dates, and expiration timelines with proactive threshold alerts. |
| **Complex Distributor Billing & Credit Accounts:** Managing variable pricing tiers, trade discounts, and credit balances across hundreds of pharmacies is prone to billing errors. | Features an integrated **Distributor Billing & Invoicing Desk** with ledger histories, automated credit management, and instant PDF invoice generation via **DomPDF**. |
| **Disposal Auditing & Regulatory Compliance:** Pharmaceutical regulations require strict documentation when medicines are broken, damaged in transit, or discarded. | Provides dedicated **Damage Reporting & Stock Discard Workflows** recording exact batch IDs, reason codes, inspector approvals, and financial loss write-offs. |
| **Data Loss Catastrophes:** Losing offline inventory data paralyzes supply chains and risks regulatory penalties. | Equipped with **Dual Cloud Backup Integration** (Google Drive API & AWS S3) for automated, scheduled database and ledger snapshots. |

---

## 🌟 Key Features

### 📦 Batch & Inventory Management
- **Batch-Level Traceability:** Track medicine batches from arrival to delivery with individual manufacturing and expiry parameters.
- **Stock Auditing & Variance Logs:** Perform regular physical stock counts against system ledgers with automatic discrepancy detection.
- **Dynamic Unit Conversions:** Support for multi-tiered packaging units (tablets, blisters, boxes, cartons).

### 🧾 Distributor Invoicing & Sales Operations
- **Invoice Generation & Dispatch:** Generate compliant sales tax invoices and delivery challans with one click.
- **Accounts Receivable Ledger:** Track distributor payment terms, outstanding balances, partial payments, and overdue interest.
- **Automated PDF Export:** Professional document rendering powered by `barryvdh/laravel-dompdf`.

### 🛡️ Warehouse Governance & Quality Control
- **Damage & Loss Auditing:** Log broken vials, crushed packaging, or compromised medicine batches with inspection sign-offs.
- **Inventory Discard Protocols:** Formal disposal pipeline for expired stock with permanent audit trails.
- **Multi-Role Access Control (RBAC):** Tailored permissions for Administrators, Logistics Managers, Inventory Clerks, and Accountants.

### 💼 Operational Management
- **Staff Payroll & Salaries:** Manage warehouse staff salaries, deductions, disbursements, and attendance logs.
- **Material Inward Entries:** Record raw ingredients, imported finished packaging, and wholesale vendor supplies.
- **Real-Time Notifications:** Live system updates and warehouse alerts powered by **Pusher** and **Laravel Reverb**.

### 🖥️ Hybrid Web & Desktop Deployment
- **Web Browser Access:** Accessible across local network (LAN) or public web domains.
- **Electron Desktop Wrapper (`main.cjs`):** Native Windows desktop app with customized keyboard shortcuts, dedicated menu controls, and automated local server bootstrapping.

---

## 🛠️ Technical Stack

- **Backend Framework:** Laravel 12.x (PHP 8.2+)
- **Database:** MySQL 8.0+ / SQLite (Optimized for high-concurrency ledger operations)
- **Document Generation:** DomPDF (`barryvdh/laravel-dompdf`)
- **Cloud Storage & Backups:** AWS S3 (`league/flysystem-aws-s3-v3`), Google Drive API (`masbug/flysystem-google-drive-ext`)
- **Real-Time Engine:** Laravel Reverb / Pusher WebSockets
- **Desktop Application:** Electron JS, Node.js (`main.cjs`, `control_center.cjs`)
- **Frontend Layer:** Blade, Tailwind CSS / Bootstrap, Modern Glassmorphic Dashboard

---

## 📦 Local Installation & Setup

### 1. Prerequisites
- PHP 8.2 or higher with extensions: `pdo_mysql`, `curl`, `fileinfo`, `gd`, `openssl`, `mbstring`
- Composer 2.x
- Node.js 18+ & NPM
- MySQL 8.0+ (or SQLite)

### 2. Setup Application
```bash
# Clone the repository
git clone https://github.com/ranaumairnawaz/AlifPharmaERP.git
cd AlifPharmaERP

# Install backend dependencies
composer install

# Install frontend dependencies
npm install

# Setup environment
cp .env.example .env
php artisan key:generate
```

### 3. Database Configuration
Configure your database connection in `.env`:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=alifpharma_db
DB_USERNAME=root
DB_PASSWORD=
```

### 4. Run Migrations & Launch
```bash
# Run database schema migrations
php artisan migrate --seed

# Build frontend assets
npm run build

# Start local web server
php artisan serve
```

### 5. Launch Desktop App (Optional)
```bash
npm run electron
# Or launch directly via LaunchAlifPharma.bat
```

---

## 👨‍💻 Author
**Rana Umair Nawaz**  
- [GitHub Profile](https://github.com/ranaumairnawaz)  
- [LinkedIn Profile](https://linkedin.com/in/ranaumairnawaz)
