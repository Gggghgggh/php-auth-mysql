# PHP Authentication with MySQL

This is a simple user authentication system built with PHP, designed to run on a local XAMPP server.

## Features

- User registration
- User login
- Password hashing for security
- Simple session management
- Simple dashboards for the diferent roles

## Requirements

- XAMPP (PHP and MySQL)
- Web browser

## Setup Instructions

1. **Install XAMPP**  
   Download and install XAMPP from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html).

2. **Start Apache and MySQL**  
   Open XAMPP Control Panel and start Apache and MySQL modules.

3. **Create Database**  
   - Open `http://localhost/phpmyadmin` in your browser.  
   - Create a new database named `auth_db` (or any name you prefer).  
   - Import `users.sql` file in the root directory or create the `users` table with fields like `id`, `name`, `phone`, `password` `role`,  and `created_at`.

4. **Clone Repository**  
   ```bash
   git clone https://github.com/yourusername/your-repo-name.git
   
5. **Copy the files into the htdocs folder inside your XAMPP installation directory** (e.g., `C:\xampp\htdocs\your-repo-name`).

6. **Configure Database Connection**
   - Open the database configuration file (e.g., `config.php`) and update the credentials if needed:
   ```bash
   $host = 'localhost';
   $db = 'auth_db';
   $user = 'root';
   $pass = '';
7. **Run the Application**
   - Visit `http://localhost/your-repo-name` in your browser to use the authentication system.
