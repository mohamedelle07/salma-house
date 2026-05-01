# Salma House - MVC PHP Project

## Project Description
Salma House is a web application for managing a pastry shop.  
It is built using PHP, MySQL, and follows the MVC architecture with Object-Oriented Programming.

---

## Technologies Used
- PHP (OOP)
- MySQL (PDO)
- HTML / CSS
- MVC Architecture
- XAMPP (Apache + MySQL)

---

## Features

### Authentication System
- User login and logout
- Session management
- Role-based access (admin / user)
- Password hashing (secure login)

### Product Management (Admin)
- Add new products
- Edit products
- Delete products
- Upload product images

### User Features
- View all products
- Search products by:
  - Name
  - Category
  - Price

### File Upload
- Image upload system using PHP $_FILES
- Images stored in /public/uploads

---

## Database Structure

The project contains 3 main tables:

- users (id, name, email, password, role)
- products (id, name, description, price, image, category_id)
- categories (id, name)

---

## Installation Guide

1. Install XAMPP
2. Start Apache and MySQL
3. Open phpMyAdmin:
   http://localhost/phpmyadmin
4. Create a new database (e.g., salma_house)
5. Import the file `database.sql` into the database
6. Move the project to:
   C:\xampp\htdocs\salma-house
7. Open the application in your browser:
   http://localhost/salma-house/public/login.php

---
5. Open browser:

## Login Credentials

### Admin Account
- Email: admin@test.com
- Password: 123456

### User Account
- Email: user@test.com
- Password: user123

---

## Project Structure

- /app → MVC logic (Models, Controllers, Services)
- /public → Entry point (views, routes, assets)
- /uploads → Uploaded images storage

---

## Security Features
- PDO prepared statements (SQL injection protection)
- Session-based authentication
- Role-based access control

---

## Author
Student Project - MVC PHP Application
