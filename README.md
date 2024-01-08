# Deferment Application System

## Overview

The Deferment Application System is a comprehensive solution developed as a part of the Master of Software Engineering program at [University Name]. It aims to streamline the process of applying for academic deferment, providing a user-friendly interface for students and a robust backend for coordinators, supervisors, and office assistants. This system addresses the need for efficient handling of deferment requests, tracking, and management within academic institutions.

## Features

- **Student Applications**: Students can submit deferment requests with necessary documentation and track their status.
- **Supervisor Review**: Supervisors can review applications, provide feedback, and make recommendations.
- **Coordinator Approval**: Coordinators can approve or reject applications based on provided information and supervisor recommendations.
- **Assistant Officer Role**: Assistant officers can manage and oversee the application process, ensuring smooth operations.
- **Status Tracking and Logs**: Detailed logging of all actions taken on each application for auditing and tracking purposes.
- **Document Management**: Support for multiple documents per application, allowing students to provide all necessary evidence.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes.

### Prerequisites

- PHP >= 7.3
- Laravel 8.x
- MySQL or another compatible database system (SQLite)
- Composer for managing PHP dependencies

### Installing

1. Clone the repository to your local machine:

```bash
git clone https://github.com/PYRAMID-FT27/DoSAS
```
2. Install dependencies using Composer:
```bash
composer install
```
3. Run migrations to set up the database schema:
```bash
php artisan migrate
```
4. Start the development server:
```bash
php artisan serve
```
