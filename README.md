# AWS---Samay

# Live on AWS 

http://13.233.199.54/

# Samay — Watch E-Commerce Platform

A PHP and MySQL-based e-commerce website for browsing watches, exploring product categories, and managing an online shopping experience. This project was deployed on **Amazon Web Services (AWS)** using Amazon EC2, Apache, PHP, and MariaDB/MySQL.

## Overview

Samay is a database-driven watch e-commerce application. Its product catalog is served dynamically from a relational database, while PHP handles the server-side application logic.

The deployment moves the application from a local development environment to a cloud-hosted Linux server, making it accessible through a web server running on an EC2 instance.

## Tech Stack

| Technology | Purpose |
|---|---|
| PHP | Server-side application logic |
| MySQL / MariaDB | Product catalog and relational data storage |
| HTML, CSS, JavaScript | User interface and client-side interactions |
| Amazon EC2 | Cloud-based virtual server |
| Amazon Linux 2023 | Server operating system |
| Apache HTTP Server | Serves the website and processes PHP requests |
| SSH | Remote server administration |
| SQL | Database schema and data import |

## AWS Architecture

The application uses a single EC2 instance to host the web server, PHP application, and database service.

```text
             User / Browser
                   |
               HTTP :80
                   |
                   v
          Amazon EC2 Instance
            Amazon Linux 2023
                   |
             Apache HTTPD
                   |
              PHP Application
               (Samay)
                   |
                   v
            MariaDB / MySQL
             Database: samay
```

This single-server architecture keeps the deployment straightforward and suitable for a student project. The application and database share the same server, so no separate database instance is required.

## Deployment on AWS

### 1. Provisioning the EC2 Instance

Created an EC2 instance in the AWS Mumbai Region (`ap-south-1`) using Amazon Linux 2023.

The instance provides the Linux environment in which the application, web server, and database run. SSH access was used for remote administration.

### 2. Connecting to the Server

Connected to the instance using SSH with the EC2 key pair and the `ec2-user` account.

```bash
ssh -i samay-cc.pem ec2-user@<EC2-PUBLIC-IP>
```

The private key provides authenticated access to the instance. The actual key file is kept outside the repository.

### 3. Installing the Server Dependencies

Installed the required packages for hosting the PHP application, including Apache, PHP, PHP database extensions, and supporting utilities.

```bash
sudo dnf install httpd php php-fpm php-mysqli php-json php-mbstring php-xml unzip -y
```

Enabled and started the Apache service:

```bash
sudo systemctl enable --now httpd
```

Apache acts as the web server, while PHP executes the application code on the server.

### 4. Transferring the Application

Packaged the project files into a ZIP archive, transferred them to the EC2 instance, and extracted the application into the web server's document root.

The deployed application was placed under:

```text
/var/www/html/
```

The deployment included the PHP pages, shared application components, CSS, JavaScript, image assets, and SQL database backup required by the project.

### 5. Setting Up the Database

Used the project's `database.sql` file to create and populate the database on the server.

The application was configured to connect to the `samay` database using the database connection settings in `db.php`.

A dedicated database user, `samay_app`, was configured for application access.

Keeping the catalog in a relational database allows the application to retrieve product information dynamically instead of relying on hardcoded product listings.

### 6. Configuring and Testing the Application

Checked the database connection and verified that product information could be retrieved from the deployed database.

Validation included:

- Confirming the database connection.
- Checking product records and catalog queries.
- Verifying product, brand, and category data.
- Checking the Apache HTTP response.
- Reviewing product image URLs and their use in the catalog.

The deployment checks confirmed that the server returned **HTTP 200** and that the database catalog queries returned product data.

### 7. Updating the Website

The deployment workflow also supported updating application assets, including CSS, on the EC2 server over SSH. This made it possible to refine the website's presentation without rebuilding the entire server environment.

## Project Structure

The application uses a conventional PHP project structure, with shared components and database configuration separated from individual pages.

```text
samay/
├── index.php
├── db.php
├── database.sql
├── includes/
│   ├── bootstrap.php
│   └── product-card.php
├── session/
├── assets/
└── [other application pages and resources]
```

*The exact directory contents depend on the deployed project version.*

## Technical Insights

**Database-driven catalog:** Product data is retrieved through SQL queries, separating catalog information from the page presentation.

**Separation of responsibilities:** PHP handles server-side logic, MySQL/MariaDB stores structured data, and Apache serves incoming web requests.

**Linux service management:** Apache is managed using `systemctl`, allowing the service to start automatically and be administered remotely.

**Cloud deployment workflow:** The process covers provisioning, secure remote access, dependency installation, application transfer, database import, configuration, and validation.

**Practical troubleshooting:** Deployment required checking service availability, database connectivity, server responses, catalog queries, and static asset paths rather than assuming that a successfully uploaded website was fully functional.

## Security and Deployment Notes

- Keep private SSH keys and database credentials out of version control.
- Restrict SSH access to trusted IP addresses.
- Do not expose the database port publicly when the database is hosted on the same instance.
- Use HTTPS and appropriate server configuration before treating the deployment as production-ready.
- Maintain database backups before making schema or data changes.

## Current Architecture and Scope

The deployed setup uses a single EC2 instance running Amazon Linux 2023, Apache, PHP, and MariaDB/MySQL.

It does not depend on a separate Amazon RDS database, S3-hosted application assets, CloudFront, or a load balancer. Those services are outside the scope of the implementation described here.

## Learning Outcomes

This project provided practical experience with:

- Deploying a PHP application on a cloud-based Linux server.
- Administering an EC2 instance through SSH.
- Configuring Apache and PHP for web hosting.
- Importing and connecting a relational database.
- Diagnosing database, application, and asset-loading issues.
- Validating a deployment through service checks, SQL queries, and HTTP responses.

---

**Samay** — A watch e-commerce project deployed using AWS EC2, Apache, PHP, and MySQL/MariaDB.
