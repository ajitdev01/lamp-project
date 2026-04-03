<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:1a1a2e,50:16213e,100:0f3460&height=200&section=header&text=LAMP%20Project%20Collection&fontSize=45&fontColor=e94560&animation=fadeIn&fontAlignY=38&desc=Full-Stack%20Web%20Applications%20|%20PHP%20•%20MySQL%20•%20Apache&descAlignY=55&descSize=16&descColor=a8b2d8" />

<br/>

[![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white)](https://httpd.apache.org)
[![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)](https://getbootstrap.com)
[![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)](https://tailwindcss.com)

<br/>

[![GitHub stars](https://img.shields.io/github/stars/ajitdev01/lamp-project?style=social)](https://github.com/ajitdev01/lamp-project/stargazers)
[![GitHub forks](https://img.shields.io/github/forks/ajitdev01/lamp-project?style=social)](https://github.com/ajitdev01/lamp-project/network)
[![GitHub commits](https://img.shields.io/github/commit-activity/m/ajitdev01/lamp-project?color=brightgreen&label=commits)](https://github.com/ajitdev01/lamp-project/commits)

<br/>

> **A production-inspired collection of 7 full-stack web applications** built with the LAMP stack.  
> Covering real-world use cases: railway booking, OTP auth, CRUD, messaging, library management & more.

<br/>

[🚆 IRCTC Clone (Main)](#-irctc-clone--flagship-project) · [📁 All Projects](#-all-projects) · [⚙️ Setup](#️-installation--setup) · [🧑‍💻 Author](#-author)

</div>

---

## 🌟 Why This Repository?

This isn't just a collection of tutorials — it's a **portfolio-grade, real-world LAMP stack showcase** built from scratch. Every project simulates a production environment, using secure sessions, hashed passwords, SMTP email delivery, and normalized MySQL databases.

```
7 Projects  ·  Full-Stack  ·  Secure Auth  ·  OTP Email  ·  Railway Booking  ·  Responsive UI
```

---

## 🏆 Highlights at a Glance

| Feature | Details |
|---|---|
| 🔐 **Security** | `password_hash()`, session management, OTP time-limited tokens |
| 🗄️ **Database** | MySQL with normalized schemas, relational joins, foreign keys |
| 📧 **Email** | PHPMailer + SMTP for OTP delivery (Gmail / SMTP) |
| 🎨 **Frontend** | Bootstrap 5 + Tailwind CSS for all responsive UIs |
| 🚆 **Flagship** | IRCTC-style railway booking — search, book, cancel, PNR, OTP |
| 💬 **Messaging** | Full inbox/sent message system with read/unread tracking |
| 📚 **Library** | Issue/return books with full member & catalog management |

---

## 🚆 IRCTC Clone — Flagship Project

> **The most complex and complete project in this repository.**  
> A fully functional railway ticket booking system inspired by the real IRCTC platform.

<div align="center">

```
╔══════════════════════════════════════════════════════════════════╗
║              🚆  IRCTC Clone — Feature Overview                  ║
╠══════════════════════════════════════════════════════════════════╣
║  🔍 Train Search       →  Source + Destination + Date           ║
║  🎫 Ticket Booking     →  Seat selection & passenger details     ║
║  ❌ Ticket Cancellation →  Cancel with refund workflow           ║
║  📋 PNR Status         →  Real-time booking status lookup        ║
║  🔐 User Auth          →  Register, Login, Session               ║
║  📧 Forgot Password    →  OTP via Email (PHPMailer/SMTP)         ║
║  📊 User Dashboard     →  Full booking history & profile         ║
╚══════════════════════════════════════════════════════════════════╝
```

</div>

### 📐 IRCTC Database Schema

```sql
-- Core tables used in IRCTC-Clone
trains          (train_id, train_name, source, destination, departure, arrival, seats)
users           (user_id, name, email, password_hash, phone, created_at)
bookings        (booking_id, user_id, train_id, pnr, journey_date, status, booked_at)
passengers      (passenger_id, booking_id, name, age, gender, seat_no)
otp_tokens      (token_id, email, otp_code, expires_at, is_used)
```

### 🔄 Booking Workflow

```
User Login → Search Train → Select Train → Fill Passenger Details
     ↓
  Generate PNR → Store in DB → Show Confirmation
     ↓
  View Dashboard → Cancel / Check PNR Status
```

### 📁 IRCTC Folder Structure

```
IRCTC-Clone/
├── index.php               # Home / Train search
├── login.php               # User login
├── register.php            # New user registration
├── forgot_password.php     # OTP-based password reset ✉️
├── dashboard.php           # User booking history
├── search_results.php      # Train listing page
├── booking.php             # Passenger & seat form
├── booking_confirm.php     # Confirmation + PNR
├── cancel_ticket.php       # Cancel booking
├── pnr_status.php          # PNR lookup
├── logout.php              # Session destroy
├── config.php              # DB connection
└── assets/
    ├── css/                # Custom styles
    └── js/                 # Client-side validation
```

---

## 📁 All Projects

### 🔐 1. Login System

Secure, production-style user authentication with PHP sessions and hashed password storage.

```
📦 Features
 ├── ✅ User Registration & Login
 ├── ✅ password_hash() + password_verify()
 ├── ✅ PHP Session-based Auth
 └── ✅ Logout & Session Destroy
```

**Core snippet:**
```php
// Secure password hashing on registration
$hashed = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Verify on login
if (password_verify($_POST['password'], $row['password'])) {
    $_SESSION['user_id'] = $row['id'];
    header("Location: dashboard.php");
}
```

---

### 📲 2. OTP Verification System

Time-limited OTP generation and email delivery using PHPMailer + SMTP. Integrated into the IRCTC Clone for password recovery.

```
📦 Features
 ├── ✅ 6-digit OTP generation
 ├── ✅ Email delivery via PHPMailer / Gmail SMTP
 ├── ✅ OTP expiry check (time-limited)
 └── ✅ Pluggable into any auth flow
```

**OTP Generation Logic:**
```php
$otp = rand(100000, 999999);
$expires_at = date('Y-m-d H:i:s', strtotime('+10 minutes'));

// Store in DB
$stmt = $conn->prepare("INSERT INTO otp_tokens (email, otp_code, expires_at) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $email, $otp, $expires_at);
$stmt->execute();

// Send via PHPMailer
$mail->addAddress($email);
$mail->Subject = 'Your OTP Code';
$mail->Body = "Your OTP is: <b>$otp</b>. Valid for 10 minutes.";
$mail->send();
```

---

### ✅ 3. Attendance System

A database-driven daily attendance tracker for students or employees.

```
📦 Features
 ├── ✅ Mark Present / Absent
 ├── ✅ View attendance by date or user
 ├── ✅ Admin panel for record management
 └── ✅ MySQL-backed storage with timestamps
```

**Schema:**
```sql
CREATE TABLE attendance (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    date DATE,
    status ENUM('Present', 'Absent'),
    marked_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

### 🗃 4. CRUD Application

A clean, reusable demonstration of all four database operations — the backbone of every web application.

```
📦 Features
 ├── ✅ Create — Insert records via form
 ├── ✅ Read   — Display data in responsive table
 ├── ✅ Update — Edit existing records inline
 └── ✅ Delete — Remove with confirmation prompt
```

**Operations at a glance:**
```
[Add New] → INSERT INTO table VALUES (...)
[View All] → SELECT * FROM table
[Edit]     → UPDATE table SET ... WHERE id = ?
[Delete]   → DELETE FROM table WHERE id = ?
```

---

### 📚 5. Library Management System

Full catalog and member management with book issue/return tracking.

```
📦 Features
 ├── ✅ Add / Manage Books & Members
 ├── ✅ Issue & Return Workflow
 ├── ✅ Search & Filter Catalog
 └── ✅ Admin Dashboard for all records
```

**Schema:**
```sql
books    (book_id, title, author, genre, total_copies, available_copies)
members  (member_id, name, email, phone, joined_date)
issued   (issue_id, book_id, member_id, issue_date, return_date, status)
```

---

### 💬 6. Send Message System

A full inbox/outbox messaging module between registered users.

```
📦 Features
 ├── ✅ Compose & Send to any user
 ├── ✅ Inbox + Sent views
 ├── ✅ Read / Unread status tracking
 └── ✅ Database-persisted message threads
```

---

## 🗂 Repository Structure

```
lamp-project/
│
├── 🚆 IRCTC-Clone/          # Railway booking system (FLAGSHIP)
│   ├── index.php
│   ├── booking.php
│   ├── forgot_password.php
│   └── ...
│
├── 🔐 LoginSystem/           # User authentication
├── 📲 OTP-Send/              # OTP email verification
├── ✅ AttendanceSystem/      # Daily attendance tracker
├── 🗃 CURD/                  # CRUD operations demo
├── 📚 library-system/        # Book & member management
├── 💬 Send-Message/          # User messaging module
│
└── 📄 README.md
```

---

## 🛠 Tech Stack

<div align="center">

| Layer | Technology | Purpose |
|---|---|---|
| **Backend** | PHP 8.x | Server-side logic, form handling |
| **Database** | MySQL 8.0 | Data storage, relational queries |
| **Server** | Apache 2.4 | HTTP server via XAMPP/WAMP/LAMP |
| **Frontend** | Bootstrap 5 + Tailwind CSS | Responsive UI components |
| **Email** | PHPMailer + SMTP | OTP delivery, notifications |
| **Dev Tools** | XAMPP / WAMP, phpMyAdmin | Local development & DB management |
| **Version Control** | Git + GitHub | Source control |

</div>

---

## ⚙️ Installation & Setup

### Prerequisites

- PHP 8.x
- MySQL 8.0
- Apache (XAMPP / WAMP / LAMP)
- Composer (for PHPMailer in OTP/IRCTC projects)

### Step 1 — Clone the Repository

```bash
git clone https://github.com/ajitdev01/lamp-project.git
cd lamp-project
```

### Step 2 — Move to Server Root

```bash
# XAMPP (Windows/Mac)
cp -r lamp-project/ /xampp/htdocs/

# WAMP (Windows)
cp -r lamp-project/ /wamp64/www/

# Linux LAMP
sudo cp -r lamp-project/ /var/www/html/
```

### Step 3 — Start Apache & MySQL

```bash
# Linux
sudo service apache2 start
sudo service mysql start

# Or use XAMPP Control Panel on Windows/Mac
```

### Step 4 — Import Database

1. Open **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Click **New** → Create database (e.g., `lamp_project`)
3. Select the database → **Import** → Upload `.sql` file from the project folder

### Step 5 — Configure Database Connection

Edit `config.php` in each project subfolder:

```php
<?php
$host     = "localhost";
$username = "root";
$password = "";             // Your MySQL password
$database = "lamp_project"; // Match your created DB name

$conn = mysqli_connect($host, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### Step 6 — Configure SMTP (for OTP & IRCTC)

In `OTP-Send/` and `IRCTC-Clone/forgot_password.php`:

```php
$mail->isSMTP();
$mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'your_email@gmail.com';  // Your Gmail
$mail->Password   = 'your_app_password';      // Gmail App Password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;
```

> ⚠️ **Note:** Use a [Gmail App Password](https://myaccount.google.com/apppasswords), not your regular Gmail password.

### Step 7 — Open in Browser

```
http://localhost/lamp-project/                      # Root
http://localhost/lamp-project/IRCTC-Clone/          # 🚆 Flagship
http://localhost/lamp-project/LoginSystem/          # 🔐 Auth
http://localhost/lamp-project/OTP-Send/             # 📲 OTP
http://localhost/lamp-project/library-system/       # 📚 Library
http://localhost/lamp-project/AttendanceSystem/     # ✅ Attendance
http://localhost/lamp-project/Send-Message/         # 💬 Messaging
http://localhost/lamp-project/CURD/                 # 🗃 CRUD
```

---

## 🎯 Learning Objectives

By exploring this repository, you will understand:

- ✅ **PHP Backend** — Form handling, server-side validation, include/require patterns
- ✅ **MySQL** — Schema design, CRUD queries, JOINs, prepared statements (SQL injection prevention)
- ✅ **Authentication** — Session management, password hashing, OTP-based verification
- ✅ **Email Integration** — PHPMailer + SMTP setup, HTML emails
- ✅ **Responsive UI** — Bootstrap 5 components + Tailwind utility classes
- ✅ **Real-world workflows** — Railway booking flow, library issue/return, messaging inbox
- ✅ **Code Organisation** — Modular PHP with `config.php`, reusable components

---

## 🚀 Future Improvements

- [ ] 🔑 JWT-based stateless authentication
- [ ] 🐳 Docker containerization (`docker-compose.yml` for full stack)
- [ ] ☁️ Cloud deployment — AWS EC2 / Railway / Azure
- [ ] 📡 REST API layer with JSON responses
- [ ] 🛡️ Role-based access control (Admin / User / Guest)
- [ ] ⚛️ React or Vue.js frontend integration
- [ ] 🧪 PHPUnit test coverage
- [ ] 🔔 Real-time notifications (WebSockets / Pusher)

---

## 📊 Project Complexity Overview

```
IRCTC-Clone        ████████████████████  ★★★★★  (Most Complex)
LoginSystem        ██████░░░░░░░░░░░░░░  ★★☆☆☆
OTP-Send           ████████░░░░░░░░░░░░  ★★★☆☆
library-system     █████████████░░░░░░░  ★★★★☆
AttendanceSystem   ██████░░░░░░░░░░░░░░  ★★☆☆☆
Send-Message       ████████████░░░░░░░░  ★★★★☆
CURD               ████░░░░░░░░░░░░░░░░  ★☆☆☆☆  (Beginner Friendly)
```

---

## 🤝 Contributing

Contributions are welcome! Here's how:

```bash
# 1. Fork the repository
# 2. Create your feature branch
git checkout -b feature/YourFeatureName

# 3. Commit your changes
git commit -m "feat: add your feature description"

# 4. Push to your branch
git push origin feature/YourFeatureName

# 5. Open a Pull Request
```

---

## 👤 Author

<div align="center">

**Ajit Kumar**

[![GitHub](https://img.shields.io/badge/GitHub-ajitdev01-181717?style=for-the-badge&logo=github)](https://github.com/ajitdev01)

*Building real-world full-stack projects with the LAMP stack.*

</div>

---

<div align="center">

<img src="https://capsule-render.vercel.app/api?type=waving&color=0:0f3460,50:16213e,100:1a1a2e&height=120&section=footer" />

**⭐ If this repository helped you, please consider giving it a star! ⭐**

*Made with ❤️ using PHP, MySQL, Apache, and a lot of coffee ☕*

</div>
