<h1 align="center">💰 Income Tax Management System</h1>

<p align="center">
  <b>A Full-Stack Web Application for Automated Income Tax Calculation & Management</b><br>
  Built using PHP, MySQL, HTML, CSS & JavaScript
</p>

<p align="center">
  <a href="http://incometaxmanagement.wuaze.com">
    <img src="https://img.shields.io/badge/🚀 Live Demo-Visit Now-success?style=for-the-badge">
  </a>
</p>

<p align="center">
  <img src="https://img.shields.io/badge/PHP-Backend-777BB4?style=for-the-badge&logo=php">
  <img src="https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql">
  <img src="https://img.shields.io/badge/HTML5-Markup-E34F26?style=for-the-badge&logo=html5">
  <img src="https://img.shields.io/badge/CSS3-Styling-1572B6?style=for-the-badge&logo=css3">
  <img src="https://img.shields.io/badge/JavaScript-Frontend-F7DF1E?style=for-the-badge&logo=javascript">
  <img src="https://img.shields.io/badge/Server-XAMPP-orange?style=for-the-badge">
  <img src="https://img.shields.io/badge/License-Educational-blue?style=for-the-badge">
</p>

---

## 📌 Project Overview

The **Income Tax Management System** is a web-based platform designed to automate income tax calculation and management for college employees.

It provides secure authentication, tax computation based on predefined slabs, deduction handling, tax payment tracking, and administrative control through a structured dashboard.

> 💡 This system simplifies tax processing, improves accuracy, and digitizes employee tax management efficiently.

---

## 🌐 Live Application

🔗 Access the deployed system here:  
**http://incometaxmanagement.wuaze.com**

---

## ✨ Core Features

### 👤 User Features

- Secure Registration & Login  
- PAN & Aadhaar Verification  
- Income Tax Calculation Based on Slabs  
- Employee Category-Based Tax Cuts  
- Allowances & Deductions Management  
- Tax Payment Tracking  
- Tax History Dashboard  
- Email OTP-Based Password Reset  

---

### 🛠️ Admin Features

- Admin Dashboard  
- Manage Employee Records  
- View All Tax Calculations  
- Track Tax Payments  
- Manage Users  
- View Login History  
- Monitor Contact Queries  

---

## 📊 Tax Slabs (FY 2025–26)

| Income Range | Tax Rate |
|--------------|----------|
| ₹0 – ₹4,00,000 | 0% |
| ₹4,00,001 – ₹8,00,000 | 5% |
| ₹8,00,001 – ₹12,00,000 | 10% |
| ₹12,00,001 – ₹16,00,000 | 15% |
| ₹16,00,001 – ₹20,00,000 | 20% |
| ₹20,00,001 – ₹24,00,000 | 25% |
| Above ₹24,00,000 | 30% |

---

## 🎨 UI & Styling Approach

The application follows a clean and professional dashboard-based design:

- Structured Employee Data Forms  
- Tax Calculation Result Tables  
- Clean Admin Dashboard Layout  
- Consistent Typography & Color Palette  
- Secure Input Validation UI  
- Responsive Layout  

### CSS Techniques Used

- Flexbox for layout alignment  
- Grid for dashboard structuring  
- Styled data tables  
- Hover transitions & button effects  
- Box-shadow & border-radius for modern interface  

---

## 🏗️ System Architecture

```
Employee (Browser)
        ↓
Frontend (HTML + CSS + JavaScript)
        ↓
Backend (PHP Business Logic)
        ↓
MySQL Database
        ↓
Admin Dashboard & Payment Tracking
```

---

## 🗄️ Database Structure

### Main Tables

| Table Name | Description |
|------------|------------|
| registrations | Stores user details |
| employees | Stores employee income data |
| tax_calculations | Stores tax history records |
| logins | Stores login activity |
| contacts | Stores contact form submissions |

---

## 📂 Project Structure

```
income-tax-management-system/
│
├── welcome.html
├── loginn.html
├── createaccount.html
├── dashboard.php
├── calculate_tax.php
├── payment.php
│
├── admin/
│   ├── admin_dashboard.php
│   ├── manage_records.php
│
├── css/
├── js/
├── includes/
│   ├── db.php
│
├── database.sql
└── README.md
```

---

## ⚙️ Installation Guide

### 1️⃣ Install XAMPP

Download and install XAMPP.

---

### 2️⃣ Move Project Folder

Copy the project folder into:

- `htdocs` (XAMPP)

---

### 3️⃣ Create Database

- Open phpMyAdmin  
- Create database:

```
income_tax_management
```

- Import `database.sql`

---

### 4️⃣ Configure Database Connection

Edit `db.php`:

```php
$host = "localhost";
$user = "root";
$password = "";
$database = "income_tax_management";
```

---

### 5️⃣ Run the Project

Open browser:

```
http://localhost/income-tax-management-system
```

---

## 🔐 Security Features

- Session-Based Authentication  
- PAN & Aadhaar Validation  
- Password Hashing  
- OTP-Based Password Reset  
- Secure Database Queries  
- Tax History Record Storage  

---

## 🔄 System Workflow

1. User registers or logs in  
2. Employee income details are entered  
3. Tax is calculated based on slabs  
4. Deductions & allowances applied  
5. Payment recorded  
6. Tax history saved  
7. Admin monitors records  

---

## 🎯 Future Enhancements

- Online Payment Gateway Integration  
- Tax Report Download (PDF)  
- Real-Time Tax Analytics Dashboard  
- Multi-Role Access Control  
- Cloud Deployment  
- REST API Support  

---

## 👨‍💻 Author

**Chiranjeevi Bathula**  
BTech Computer Science Engineering Student  

---

## 📜 License

This project is developed for educational purposes.

---

## ⭐ Support

If you find this project useful, consider giving it a ⭐ on GitHub!
