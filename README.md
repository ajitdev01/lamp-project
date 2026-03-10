# 🔆 LAMP Project Collection

<div align="center">

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Apache](https://img.shields.io/badge/Apache-2.4-D22128?style=for-the-badge&logo=apache&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.x-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/Tailwind-3.x-06B6D4?style=for-the-badge&logo=tailwind-css&logoColor=white)

**A comprehensive collection of full-stack web applications built on the LAMP stack.**  
Real-world backend development, database integration, modern UI frameworks, and API-based architecture — all in one repository.

[Projects](#-projects-included) · [Tech Stack](#-tech-stack) · [Installation](#-installation) · [Author](#-author)

</div>

---

## 📌 Overview

This repository is a curated collection of **18 full-stack mini-projects** built using the **LAMP stack (Linux, Apache, MySQL, PHP)**. Each project targets a distinct real-world problem — from user authentication to railway booking to server monitoring — demonstrating practical, production-style backend development with clean and responsive frontends.

> Built for **learning, experimentation, and portfolio development** to demonstrate practical full-stack web development skills.

---

## 🏆 Project Highlights

- ✅ Full-stack development using the **LAMP architecture**
- ✅ Dynamic server-side programming with **PHP**
- ✅ Relational database design and management using **MySQL**
- ✅ Modern responsive UI with **Bootstrap 5** and **Tailwind CSS**
- ✅ REST-style API communication and third-party integration
- ✅ Secure **authentication, session management**, and **OTP verification**
- ✅ Role-based access control and permission systems
- ✅ File handling, notification pipelines, and real-time dashboards
- ✅ Modular, scalable project structure

---

## 🛠 Tech Stack

| Layer | Technologies |
|---|---|
| **Backend** | PHP 8.x, REST-style APIs, Session Management |
| **Database** | MySQL 8.0, phpMyAdmin |
| **Server** | Apache 2.4 (via XAMPP / WAMP / LAMP) |
| **Frontend** | HTML5, CSS3, JavaScript, Bootstrap 5, Tailwind CSS |
| **Dev Tools** | Git, GitHub, XAMPP, WAMP |

---

## 📁 Projects Included

### 🔐 Authentication & Security

| Project | Description |
|---|---|
| **Login System** | Secure user login and registration with PHP sessions, password hashing, and database validation. |
| **OTP Verification System** | OTP-based two-factor authentication for secure login flows using email/SMS APIs. |
| **Role-Based Auth** | Full RBAC system — assign roles (Admin, Editor, Viewer) and manage permissions per user. |

---

### 📋 Data Management

| Project | Description |
|---|---|
| **CRUD Application** | Complete Create, Read, Update, Delete operations with PHP + MySQL and a clean UI. |
| **Attendance System** | Database-driven attendance tracking — mark, update, and report user attendance. |
| **Library Management System** | Manage books, members, issue/return records, and search across the catalog. |
| **Student Management** | Manage student profiles, grades, enrollment, and academic records. |
| **Expense Tracker** | Log and categorize daily expenses, view summaries, and track spending over time. |
| **Task Manager** | Create, assign, and track tasks with status updates and due dates. |

---

### 🌐 Web & Utility Tools

| Project | Description |
|---|---|
| **URL Shortener** | Generate short URLs from long links with click tracking and redirect handling. |
| **File Upload System** | Multi-file upload with validation, storage, and a browsable file manager. |
| **Blog CMS** | Full content management system — write, edit, publish, and categorize blog posts. |
| **Quiz System** | Create quizzes with multiple-choice questions, auto-score responses, and display results. |

---

### 💬 Communication & Notifications

| Project | Description |
|---|---|
| **Send Message System** | User-to-user messaging module with inbox, sent items, and backend processing. |
| **Notification System** | Real-time in-app notification delivery for system events and user actions. |
| **Ticket Support System** | Support ticket submission, assignment, status tracking, and admin resolution panel. |

---

### 🚆 Complex Systems

| Project | Description |
|---|---|
| **IRCTC Clone** | A simplified railway booking system — search trains, book tickets, manage bookings, and generate PNR. |
| **Server Monitor Dashboard** | Real-time server health dashboard displaying CPU, memory, disk usage, and uptime metrics. |

---

## 📂 Project Structure

```
lamp-project/
│
├── AttendanceSystem/          # Mark and manage attendance records
├── CRUD/                      # Basic Create, Read, Update, Delete
├── LoginSystem/               # Authentication with sessions
├── LibrarySystem/             # Book and member management
├── IRCTC-Clone/               # Railway ticket booking system
├── Send-Message/              # User messaging module
├── OTP-System/                # OTP-based verification
├── Role-Based-Auth/           # RBAC with permission control
├── URL-Shortener/             # Short link generator with analytics
├── Blog-CMS/                  # Content management system
├── Quiz-System/               # Quiz builder and evaluator
├── Task-Manager/              # Task tracking with status
├── Expense-Tracker/           # Personal finance tracker
├── Student-Management/        # Student record management
├── Ticket-Support-System/     # Support desk with ticket flow
├── File-Upload-System/        # File upload and management
├── Notification-System/       # In-app notification engine
├── Server-Monitor-Dashboard/  # Live server metrics dashboard
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
# XAMPP (Windows/macOS)
cp -r lamp-project/ /xampp/htdocs/

# WAMP (Windows)
cp -r lamp-project/ /wamp/www/

# Linux (LAMP)
cp -r lamp-project/ /var/www/html/
```

### 3. Start Services

Start both **Apache** and **MySQL** from XAMPP Control Panel or via terminal:

```bash
# Linux
sudo service apache2 start
sudo service mysql start
```

### 4. Import Database

1. Open **phpMyAdmin** → `http://localhost/phpmyadmin`
2. Create a new database (e.g., `lamp_project`)
3. Select the database → click **Import**
4. Upload the `.sql` file found in the project subfolder

### 5. Configure Database Connection

Edit `config.php` (found in each project subfolder):

```php
<?php
$host     = "localhost";
$username = "root";
$password = "";          // your MySQL password
$database = "lamp_project";

$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
```

### 6. Run the Project

Open in your browser:

```
http://localhost/lamp-project/
```

Navigate into any subfolder to run a specific project:

```
http://localhost/lamp-project/IRCTC-Clone/
http://localhost/lamp-project/LoginSystem/
http://localhost/lamp-project/Blog-CMS/
```

---

## 🎯 Learning Objectives

Working through these projects develops hands-on skills in:

- PHP backend development and MVC-style structure
- MySQL schema design, joins, and query optimization
- REST-style API integration and response handling
- OTP verification and two-factor authentication
- Secure session management and password hashing
- Role-based access control (RBAC) design
- CRUD operations with validation and error handling
- Responsive UI design with Bootstrap 5 and Tailwind CSS
- File upload, server-side validation, and storage management
- Real-time dashboard design using server metrics

---

## 🚀 Future Improvements

- [ ] JWT-based stateless authentication
- [ ] RESTful API layer with JSON responses
- [ ] Docker containerization for consistent environments
- [ ] Cloud deployment to AWS / Azure / DigitalOcean
- [ ] Advanced role and permission management system
- [ ] React or Vue.js integration for select frontend modules
- [ ] WebSocket support for real-time messaging and notifications
- [ ] Unit and integration testing with PHPUnit
- [ ] CI/CD pipeline with GitHub Actions

---

## 📸 Screenshots

> _Add screenshots of your projects here to make this README stand out on GitHub._  
> Example: `![IRCTC Clone](screenshots/irctc-clone.png)`

---

## 🤝 Contributing

Contributions, suggestions, and improvements are welcome!

1. Fork the repository
2. Create a new branch: `git checkout -b feature/your-feature`
3. Commit your changes: `git commit -m "Add: your feature description"`
4. Push to the branch: `git push origin feature/your-feature`
5. Open a Pull Request

---

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

---

## 👤 Author

**Ajit Kumar**

- GitHub: [@ajitdev01](https://github.com/ajitdev01)

> This project is built for **learning, experimentation, and portfolio development** to demonstrate practical backend and full-stack web development skills using the LAMP stack.

---

<div align="center">

⭐ **If you find this useful, consider giving it a star!** ⭐

</div>
