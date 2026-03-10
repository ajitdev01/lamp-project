# 💡 LAMP Project Collection

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)

**A collection of full-stack web applications built using the LAMP stack.**  
Real-world backend development, database integration, and modern UI design — all in one repository.

[Projects](#-projects) · [Tech Stack](#-tech-stack) · [Installation](#-installation) · [Author](#-author)

</div>

---

## 📌 Overview

This repository contains **7 full-stack mini-projects** built with the **LAMP stack (Linux, Apache, MySQL, PHP)**. Each project targets a distinct real-world use case — from user authentication and OTP verification to railway booking — demonstrating practical backend development with responsive frontends.

> Built for **learning, experimentation, and portfolio development.**

---

## 🏆 Highlights

- ✅ Full-stack development using **PHP + MySQL + Apache**
- ✅ Secure **login, session management**, and **OTP email verification**
- ✅ Complete **CRUD operations** with database integration
- ✅ Responsive UI using **Bootstrap** and **Tailwind CSS**
- ✅ Complex workflow simulation — **IRCTC-style railway booking**
- ✅ User-to-user **messaging system**
- ✅ **Library management** with book and member records

---

## 🛠 Tech Stack

| Layer | Technologies |
|---|---|
| **Backend** | PHP 8.x, Session Management |
| **Database** | MySQL, phpMyAdmin |
| **Server** | Apache (via XAMPP / WAMP / LAMP) |
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap, Tailwind CSS |
| **Dev Tools** | Git, GitHub, XAMPP / WAMP |

---

## 📁 Projects

### 🔐 Login System
Secure user authentication with registration, login, and session management. Passwords are hashed before storage and validated against the database on login.

**Key Features:**
- User registration and login
- PHP session-based authentication
- Password hashing with `password_hash()`
- Logout and session destroy

---

### 📲 OTP Verification System (`OTP-Send`)
OTP-based verification for secure user authentication. Generates a one-time password and sends it to the user's email for confirmation.

**Key Features:**
- OTP generation and email delivery
- Time-limited OTP validation
- Integrated into the login/signup flow
- Used in IRCTC-Clone for forgot password

---

### ✅ Attendance System
A database-driven system to record and manage daily attendance for users or students.

**Key Features:**
- Mark attendance (Present / Absent)
- View attendance history by date or user
- Admin panel for records management
- MySQL-backed storage

---

### 🗃 CRUD Application
Demonstrates the four fundamental database operations — Create, Read, Update, Delete — using PHP and MySQL with a clean UI.

**Key Features:**
- Add, view, edit, and delete records
- Form validation on frontend and backend
- Responsive table display
- Simple and reusable structure

---

### 📚 Library Management System (`library-system`)
Manage books, members, and library records. Supports issuing and returning books with full record tracking.

**Key Features:**
- Add and manage books and members
- Issue and return book records
- Search and filter catalog
- Admin dashboard for all records

---

### 🚆 IRCTC Clone
A simplified railway booking system inspired by the IRCTC platform. Includes train search, ticket booking, PNR tracking, and OTP-based forgot password.

**Key Features:**
- Search trains by source and destination
- Book and cancel tickets
- PNR status lookup
- Forgot password with OTP via email
- User dashboard for booking history

---

### 💬 Send Message System (`Send-Message`)
A backend-powered messaging module that allows users to send and receive messages within the application.

**Key Features:**
- Compose and send messages to other users
- Inbox and sent messages view
- Message read/unread status
- Database-stored message records

---

## 📂 Project Structure

```
lamp-project/
│
├── AttendanceSystem/     # Attendance tracking system
├── CURD/                 # CRUD operations demo
├── LoginSystem/          # User authentication
├── library-system/       # Book and member management
├── IRCTC-Clone/          # Railway booking system
├── Send-Message/         # User messaging module
├── OTP-Send/             # OTP email verification
│
└── README.md
```

---

## ⚙️ Installation

### 1. Clone the Repository

```bash
git clone https://github.com/ajitdev01/lamp-project.git
```

### 2. Move to Server Directory

```bash
# XAMPP
cp -r lamp-project/ /xampp/htdocs/

# WAMP
cp -r lamp-project/ /wamp/www/

# Linux LAMP
cp -r lamp-project/ /var/www/html/
```

### 3. Start Services

Start **Apache** and **MySQL** from XAMPP Control Panel, or via terminal:

```bash
sudo service apache2 start
sudo service mysql start
```

### 4. Import Database

1. Open **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Create a new database (e.g., `lamp_project`)
3. Click **Import** → upload the `.sql` file from the project folder

### 5. Configure Database Connection

Edit `config.php` inside any project subfolder:

```php
<?php
$host     = "localhost";
$username = "root";
$password = "";            // your MySQL password
$database = "lamp_project";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### 6. Open in Browser

```
http://localhost/lamp-project/
```

Or navigate directly to any project:

```
http://localhost/lamp-project/LoginSystem/
http://localhost/lamp-project/IRCTC-Clone/
http://localhost/lamp-project/OTP-Send/
```

---

## 🎯 Learning Objectives

- PHP backend development and form handling
- MySQL schema design and query writing
- Session-based authentication and password security
- OTP generation and email delivery via PHPMailer / SMTP
- CRUD operations with input validation
- Responsive UI design with Bootstrap and Tailwind CSS
- Building modular, real-world full-stack applications

---

## 🚀 Future Improvements

- [ ] JWT-based authentication
- [ ] Docker containerization
- [ ] Cloud deployment (AWS / Azure)
- [ ] REST API layer with JSON responses
- [ ] Role-based access control (RBAC)
- [ ] Modern frontend framework (React / Vue)

---

## 👤 Author

**Ajit Kumar**  
GitHub: [@ajitdev01](https://github.com/ajitdev01)

---

<div align="center">

⭐ **If you found this helpful, give it a star!** ⭐

</div>
