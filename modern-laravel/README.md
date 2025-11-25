# Modern Cartridge Management System - Laravel

A modern Laravel-based CRUD admin panel for managing cartridge equipment accounting, migrated from the legacy CodeIgniter PHP 5.4 system.

## Overview

This is a complete rewrite of the legacy cartridge accounting system using modern Laravel framework. The system manages cartridge inventory with full CRUD operations, change history tracking, and a clean Bootstrap 5 interface.

## Features

### Core Functionality
- ✅ **CRUD Operations**: Create, Read, Update, Delete cartridges
- ✅ **Change History Tracking**: Automatic logging of all changes
- ✅ **Auto-calculated Fields**: Service status and weight differences
- ✅ **DataTables Integration**: Sortable, searchable tables
- ✅ **Responsive Design**: Bootstrap 5 UI works on all devices
- ✅ **Form Validation**: Server-side validation with Laravel
- ✅ **Flash Messages**: User feedback for all operations

### Database Tables

#### Cartridges Table
Main table storing cartridge information:
- `id` - Unique identifier
- `owner` - Department/owner location
- `brand` - Cartridge manufacturer
- `marks` - Model designation
- `code` - Unique inventory code
- `servicename` - Service center name
- `technical_life` - Operational status (1=working, 0=out of service)
- `comments` - Additional notes
- `weight_before` - Weight before service (grams)
- `weight_after` - Weight after refill (grams)
- `date_outcome` - Date sent to service
- `date_income` - Date returned from service
- `inservice` - Auto-calculated (1=currently in service, 0=not in service)
- `created_at`, `updated_at` - Laravel timestamps

#### Cartridge Histories Table
Tracks all changes to cartridges:
- `id` - Unique identifier
- `cartridge_id` - Foreign key to cartridges table
- `owner`, `weight_before`, `weight_after`, etc. - Snapshot of data
- `log` - Short change summary
- `log_full` - Detailed change log
- `date_of_changes` - When the change occurred
- `created_at`, `updated_at` - Laravel timestamps

## Installation

### Prerequisites
- PHP 8.1+
- Composer
- MySQL 5.7+ or MariaDB
- Node.js & NPM (for frontend assets)

### Step 1: Clone and Install Dependencies

```bash
cd modern-laravel

# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### Step 2: Environment Configuration

```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### Step 3: Configure Database

Edit `.env` file with your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cartridge
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Step 4: Run Migrations

```bash
# Run migrations to create tables
php artisan migrate
```

### Step 5: Build Frontend Assets

```bash
# Build assets
npm run build

# Or for development with hot reload
npm run dev
```

### Step 6: Start Development Server

```bash
php artisan serve
```

Visit http://localhost:8000 in your browser.

## Project Structure

```
modern-laravel/
├── app/
│   ├── Http/
│   │   └── Controllers/
│   │       └── CartridgeController.php   # Main CRUD controller
│   └── Models/
│       ├── Cartridge.php                 # Cartridge model with history tracking
│       └── CartridgeHistory.php          # History model
├── database/
│   └── migrations/
│       ├── 2024_01_01_000001_create_cartridges_table.php
│       └── 2024_01_01_000002_create_cartridge_histories_table.php
├── resources/
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php             # Main layout with Bootstrap 5
│       └── cartridges/
│           ├── index.blade.php           # List all cartridges (DataTables)
│           ├── create.blade.php          # Add new cartridge form
│           ├── edit.blade.php            # Edit cartridge form
│           └── history.blade.php         # View change history
└── routes/
    └── web.php                           # Route definitions
```

## Usage Guide

### Viewing All Cartridges

Navigate to `/cartridges` or the homepage. You'll see:
- Sortable and searchable table with all cartridges
- Color-coded status indicators
- Auto-calculated weight differences
- Action buttons (Edit, History, Delete)

### Adding a New Cartridge

1. Click "Add New Cartridge" button
2. Fill in required fields:
    - Department/Owner
    - Brand
    - Model
    - Code
    - Weight before/after
    - Condition (Working/Out of Service)
3. Optional fields: Service center, dates, comments
4. Click "Add Cartridge"

### Editing a Cartridge

1. Click the edit button (yellow) on any cartridge
2. Modify editable fields (Brand and Model are read-only)
3. Click "Update Cartridge"
4. Changes are automatically logged to history

### Viewing History

1. Click the history button (blue) on any cartridge
2. See all historical changes with:
    - Change timestamps
    - What was modified
    - Full change logs
    - Previous values

### Deleting a Cartridge

1. Click the delete button (red)
2. Confirm deletion
3. Cartridge and all its history are removed

## Features Explanation

### Automatic Change Tracking

The system automatically tracks changes using Laravel's model events:

```php
// When updating a cartridge
static::updating(function ($cartridge) {
    $cartridge->updateServiceStatus();  // Auto-calculate service status
    $cartridge->logChanges();           // Log changes to history
});
```

### Service Status Calculation

The `inservice` field is automatically calculated:
- `inservice = 1`: If `date_income < date_outcome` (still at service center)
- `inservice = 0`: Otherwise (returned or never sent)

### Weight Difference

Calculated on-the-fly:
```php
$weightDifference = $cartridge->weight_after - $cartridge->weight_before;
```

## Technologies Used

### Backend
- **Laravel 11** - PHP framework
- **MySQL/MariaDB** - Database
- **Eloquent ORM** - Database abstraction

### Frontend
- **Bootstrap 5** - UI framework
- **DataTables** - Enhanced tables
- **Font Awesome 6** - Icons
- **jQuery** - DOM manipulation

## Differences from Legacy System

| Feature | Legacy (CodeIgniter) | Modern (Laravel) |
|---------|---------------------|------------------|
| PHP Version | 5.3.7+ | 8.1+ |
| Framework | CodeIgniter 3.x | Laravel 11 |
| Bootstrap | 4 | 5 |
| Database | Manual queries | Eloquent ORM |
| Validation | Manual | Laravel validation |
| Routing | CodeIgniter routes | Laravel routes |
| Change Tracking | Manual in controller | Automatic in model |
| Timestamps | Manual dates | Laravel timestamps |
| Security | Basic | CSRF, prepared statements, mass assignment protection |

## API Routes

| Method | URI | Action | Route Name |
|--------|-----|--------|------------|
| GET | `/cartridges` | List all | `cartridges.index` |
| GET | `/cartridges/create` | Show create form | `cartridges.create` |
| POST | `/cartridges` | Store new | `cartridges.store` |
| GET | `/cartridges/{id}` | Show single | `cartridges.show` |
| GET | `/cartridges/{id}/edit` | Show edit form | `cartridges.edit` |
| PUT/PATCH | `/cartridges/{id}` | Update | `cartridges.update` |
| DELETE | `/cartridges/{id}` | Delete | `cartridges.destroy` |
| GET | `/cartridges/{id}/history` | Show history | `cartridges.history` |

## Database Schema

### Cartridges Table

```sql
CREATE TABLE cartridges (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    owner VARCHAR(50) NOT NULL,
    brand VARCHAR(50) NOT NULL,
    marks VARCHAR(50) NOT NULL,
    weight_before INT DEFAULT 0,
    weight_after INT DEFAULT 0,
    date_outcome DATE NULL,
    date_income DATE NULL,
    servicename VARCHAR(30) NULL,
    comments VARCHAR(50) NULL,
    technical_life TINYINT DEFAULT 1,
    code VARCHAR(30) NOT NULL,
    inservice TINYINT DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

### Cartridge Histories Table

```sql
CREATE TABLE cartridge_histories (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cartridge_id BIGINT UNSIGNED NOT NULL,
    owner VARCHAR(40) DEFAULT 'Log start',
    weight_before INT DEFAULT 0,
    weight_after INT DEFAULT 0,
    date_outcome DATE NULL,
    date_income DATE NULL,
    servicename VARCHAR(50) DEFAULT 'Log start',
    technical_life TINYINT DEFAULT 1,
    log TEXT NULL,
    log_full TEXT NULL,
    date_of_changes DATE NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (cartridge_id) REFERENCES cartridges(id) ON DELETE CASCADE
);
```

## Development

### Running Tests

```bash
php artisan test
```

### Clearing Cache

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

### Database Refresh

```bash
# WARNING: This will delete all data
php artisan migrate:fresh
```

## Production Deployment

1. Set `APP_ENV=production` in `.env`
2. Set `APP_DEBUG=false` in `.env`
3. Run optimizations:

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

4. Set proper file permissions:

```bash
chmod -R 755 storage bootstrap/cache
```

## Troubleshooting

### Migration Errors
```bash
php artisan migrate:rollback
php artisan migrate
```

### Permission Issues
```bash
sudo chown -R www-data:www-data storage bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Composer Issues
```bash
composer dump-autoload
```

## Future Enhancements

- [ ] User authentication and authorization
- [ ] Role-based access control
- [ ] Export to Excel/PDF
- [ ] Advanced search and filtering
- [ ] Email notifications
- [ ] API endpoints for external integration
- [ ] Multi-language support
- [ ] Bulk operations
- [ ] Dashboard with statistics

## License

Open-source software. Feel free to modify and use.

## Credits

- Migrated from legacy CodeIgniter system
- Built with Laravel 11
- UI powered by Bootstrap 5
- Tables enhanced with DataTables

## Support

For issues or questions, please create an issue in the repository.
