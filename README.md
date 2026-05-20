# LivePlay

LivePlay is an E-commerce web application that allows users (general public/customers) to browse shows, select showtimes, reserve seats, and purchase their tickets online. It targets those who are looking for entertainment. It also provides the admin with an admin panel for managing these movies (CRUD operations), schedules, and user transactions (e.g., seeing all orders).

This application will reduce the need for in person ticket purchasing and improves the user’s convenience (e.g. browsing movies easily by genre and language). It also provides the admin with a centralized system to manage the movie theater efficiently.

## Main Features
- **Show Variety**
- **Internationalization**
- **File Uploads**
- **Pictures Carousel**
- **Ticket Purchasing**
- **Seats Preview**
- **Filtering**
- **In-depth Details**
- **Registration And Login**
- **Searching**
- **Show Calendar**
- **Reviews**
- **Simple Navigation Bar**
- **Sales List**
- **Flash Messages**

## Programming Languages

LivePlay utilizes the following programming languages:
- **HTML**
- **PHP**
- **JS**
- **CSS**
- **SQL**

## Authors

The LivePlay website was created by Vanier students **Farwah Bakhsh, Mustafa Hussain and Jacob Magera** as their E-Commerce final project!

## Installation

There are a few steps necessary before running the website on your own device

### Option 1: Docker

1. Clone the repository
Type the following into bash:
git clone https://github.com/FARASHAAFG/theater-app.git
cd theater-app

2. Start the containers
Type the following into bash:
docker-compose up -d

3. Access the local website
    1. Website: http://localhost/theater-app
    2. phpMyAdmin: http://localhost/phpmyadmin/
  
### Option 2: Composer 

1. Clone the repository
Clone the repo into your local server root

2. Install dependencies using Composer
Type the following into bash:
composer install

3. Configure your database
    1. Copy the contents of config/env.example.php into config/env.php
    2. Update the database name and credentials

## Project Structure

Here's how everything is organized:

```plaintext
theater-app/
├── app/
│   ├── Controllers/    # Controllers live here
│   ├── Domain/         # Domain logic and business rules
│   │   ├── Models/     # Data models and entities
│   │   └── Services/   # Business logic services
│   ├── Helpers/        # Utility classes and helpers
│   ├── Middleware/     # Custom middleware
│   ├── Routes/         # Route definitions (web & API)
│   └── Views/          # View templates
├── config/             # Configuration files and bootstrap
├── data/               # Database files, uploads, etc.
├── docker/             # Docker configuration files
│   ├── apache.conf     # Apache virtual host config
│   └── init-db/        # Database initialization scripts
├── docs/               # Documentation
├── public/             # Web-accessible files
│   ├── assets/         # Static assets (CSS, JS, images)
│   │   ├── css/        # Stylesheets
│   │   └── js/         # JavaScript files
│   ├── index.php       # Application entry point
│   └── .htaccess       # Apache rewrite rules
├── var/                # Runtime files
│   └── logs/           # Application logs
├── vendor/             # Composer dependencies
├── Dockerfile          # Docker image definition
└── docker-compose.yml  # Docker services configuration
```



## License

This project is open-sourced under the MIT License. See the `LICENSE` file for the full details.

---
