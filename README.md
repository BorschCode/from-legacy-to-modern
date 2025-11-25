# Legacy to Modern Migration Project

This project demonstrates the migration from a legacy CodeIgniter PHP 5.4 application to a modern Laravel 12 dockerized application.

## Table of Contents

- [Legacy System (CodeIgniter 3.x)](#legacy-system-codeigniter-3x)
  - [Overview](#overview)
  - [Database Schema](#database-schema)
  - [Application Structure](#application-structure)
  - [Current Features](#current-features)
  - [Configuration](#configuration)
  - [Docker Setup for Legacy](#docker-setup-for-legacy)
- [Modern System (Laravel 12 + Docker)](#modern-system-laravel-12--docker)
  - [Overview](#overview-1)
  - [Planned Improvements](#planned-improvements)
  - [Docker Setup](#docker-setup)
  - [Planned Database Improvements](#planned-database-improvements)
  - [API Endpoints](#api-endpoints-planned)
  - [Migration Strategy](#migration-strategy)
  - [Technology Stack](#technology-stack)
  - [Development Workflow](#development-workflow)

## Legacy System (CodeIgniter 3.x)

### Overview
- **Application**: Cartridge Management System (Система учёта картриджей)
- **Framework**: CodeIgniter 3.x
- **PHP Version**: 5.3.7+
- **Database**: MySQL
- **Language**: Russian interface
- **Base URL**: `http://cartridge.crud`

### Database Schema

#### Main Tables
1. **`cartridgedb`** - Primary cartridge records
   ```sql
   - id (int, auto_increment)
   - owner (varchar 50) - Department/location
   - brand (varchar 50) - Manufacturer
   - marks (varchar 50) - Model designation
   - weight_before (int) - Weight before service
   - weight_after (int) - Weight after refill
   - date_outcome (date) - Service send date
   - date_income (date) - Service return date
   - servicename (varchar 30) - Service center
   - comments (varchar 50) - Status comments
   - technical_life (tinyint) - Working condition
   - code (varchar 30) - Unique identifier
   - inservice (tinyint) - Service status
   ```

2. **`story`** - Change history/audit log
   ```sql
   - id (int, auto_increment)
   - id_item (int) - Foreign key to cartridgedb
   - log (text) - Short change history
   - log_full (text) - Full change log
   - date_of_changes (date) - Change timestamp
   ```

### Application Structure
```
legacy-codeigniter-php5-4/
├── application/
│   ├── controllers/Cartridge.php
│   ├── models/cartridge_model.php
│   ├── views/
│   │   ├── cartridge_details.php
│   │   ├── add_cartridge.php
│   │   ├── edit_details.php
│   │   └── story_of_element.php
│   └── config/
├── assets/ (Bootstrap 4, DataTables)
├── system/ (CodeIgniter core)
└── DB/ (SQL dumps)
```

### Current Features
- CRUD operations for cartridge management
- Change history tracking with detailed logs
- DataTables integration for sorting/filtering
- Bootstrap 4 responsive UI
- Russian localization
- Flash messaging system

### Configuration
- Database: `localhost/cartridge` (user: webuser)
- Session storage: File-based
- No CSRF protection
- No authentication system
- Direct SQL queries in model

### Docker Setup for Legacy

The legacy CodeIgniter application includes a complete Docker setup for development:

**Services:**
- **Web**: PHP 5.6 + Apache (Port: 8080)
- **Database**: MySQL 5.7 (Port: 3306)
- **PhpMyAdmin**: Database management (Port: 8081)

**Quick Start:**
```bash
cd legacy-codeigniter-php5-4
docker-compose up -d --build
```

**Access:**
- Application: http://localhost:8080
- PhpMyAdmin: http://localhost:8081

For detailed setup instructions, see: [DOCKER_SETUP.md](legacy-codeigniter-php5-4/DOCKER_SETUP.md)

---

## Modern System (Laravel 12 + Docker)

### Overview
- **Framework**: Laravel 12
- **PHP Version**: 8.3+
- **Database**: MySQL 8.0
- **Containerization**: Docker & Docker Compose
- **Architecture**: Modern MVC with API support

### Planned Improvements

#### Security Enhancements
- CSRF protection enabled
- Input validation with Form Requests
- Eloquent ORM (SQL injection prevention)
- Authentication system (Laravel Sanctum)
- Rate limiting

#### Modern Architecture
- Eloquent models with relationships
- Resource controllers
- API endpoints (JSON responses)
- Service layer pattern
- Repository pattern for data access

#### Development Features
- Environment-based configuration
- Database migrations and seeders
- Automated testing (PHPUnit)
- Code formatting (Laravel Pint)
- Queue system for background tasks

#### Docker Setup

The modern Laravel application uses Laravel Sail for Docker development:

**Services:**
- **Laravel App**: PHP 8.4 + Nginx (Port: 80)
- **MySQL**: MySQL 8.0 (Port: 3306)
- **Redis**: For queues and caching
- **Vite**: For asset compilation (Port: 5173)

**Quick Start:**
```bash
cd modern-laravel
./vendor/bin/sail up -d
```

**Directory Structure:**
```
modern-laravel/
├── compose.yaml           # Laravel Sail configuration
├── app/                   # Laravel application code
├── database/              # Migrations and seeders
├── resources/             # Views, assets, lang files
├── routes/                # Web and API routes
├── tests/                 # PHPUnit tests
└── vendor/                # Composer dependencies
```

**Environment Setup:**
1. Copy `.env.example` to `.env`
2. Generate application key: `./vendor/bin/sail artisan key:generate`
3. Run migrations: `./vendor/bin/sail artisan migrate`
4. Seed database: `./vendor/bin/sail artisan db:seed`

### Planned Database Improvements
- Proper foreign key constraints
- Database indexes for performance
- Soft deletes for audit trail
- Timestamps (created_at, updated_at)
- UUID primary keys option

### API Endpoints (Planned)
```
GET    /api/cartridges          - List all cartridges
POST   /api/cartridges          - Create cartridge
GET    /api/cartridges/{id}     - Show cartridge
PUT    /api/cartridges/{id}     - Update cartridge
DELETE /api/cartridges/{id}     - Delete cartridge
GET    /api/cartridges/{id}/history - Get change history
```

### Migration Strategy
1. **Database Migration**: Convert existing data to Laravel migrations
2. **Model Creation**: Eloquent models with relationships
3. **Controller Refactoring**: Resource controllers with validation
4. **View Modernization**: Blade templates with modern UI
5. **API Development**: RESTful API endpoints
6. **Docker Setup**: Complete containerization
7. **Testing**: Comprehensive test suite

### Technology Stack
- **Backend**: Laravel 12, PHP 8.3
- **Database**: MySQL 8.0
- **Frontend**: Blade templates, Alpine.js, Tailwind CSS
- **Containerization**: Docker, Docker Compose
- **Web Server**: Nginx
- **Queue**: Redis
- **Testing**: PHPUnit, Laravel Dusk

### Development Workflow
- Git version control
- Feature branch workflow
- Automated testing pipeline
- Code quality checks
- Docker development environment