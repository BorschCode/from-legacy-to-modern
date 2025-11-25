# Docker Setup for Legacy CodeIgniter Application

This setup provides a complete dockerized environment for the legacy CodeIgniter 3.x application running on PHP 5.6.

## Prerequisites

- Docker (20.10+)
- Docker Compose (1.29+)

## Services Overview

The Docker Compose configuration includes:

1. **web** - PHP 5.6 with Apache for CodeIgniter application
   - Default Port: 8080 (configurable via .env)
   - Volume mounted for live code updates

2. **db** - MySQL 5.7 database server
   - Default Port: 3306 (configurable via .env)
   - Database: cartridge
   - User: webuser
   - Password: 123
   - Root Password: root

3. **phpmyadmin** - Database management interface
   - Default Port: 8081 (configurable via .env)
   - Access via http://localhost:8081

## Port Configuration

The application uses environment variables for port configuration. You can customize ports in two ways:

### Option 1: Using .env file (Recommended)

1. The `.env` file is already created with your custom ports:
   ```env
   WEB_PORT=8036
   DB_PORT=3389
   PHPMYADMIN_PORT=8081
   ```

2. Modify the `.env` file to change ports or other settings

### Option 2: Using docker-compose.override.yml

1. Copy the example override file:
   ```bash
   cp docker-compose.override.yml.example docker-compose.override.yml
   ```

2. Edit `docker-compose.override.yml` with your custom settings

## Quick Start

### 1. Navigate to the Project Directory

```bash
cd legacy-codeigniter-php5-4
```

### 2. Build and Start Containers

```bash
docker-compose up -d --build
```

### 3. Access the Application

With the current .env configuration:
- **CodeIgniter App**: http://localhost:8036
- **PhpMyAdmin**: http://localhost:8081
- **MySQL Database**: localhost:3389

### 4. Import Database (if you have SQL files)

If you have SQL dump files in the `DB/` directory, they will be automatically imported when the database container starts for the first time.

Alternatively, use PhpMyAdmin:
1. Navigate to http://localhost:8081
2. Login with root/root
3. Select the `cartridge` database
4. Import your SQL file

## Common Commands

### View Logs
```bash
# All services
docker-compose logs -f

# Specific service
docker-compose logs -f web
docker-compose logs -f db
```

### Stop Containers
```bash
docker-compose down
```

### Stop and Remove Volumes (WARNING: This deletes database data)
```bash
docker-compose down -v
```

### Rebuild Containers
```bash
docker-compose up -d --build
```

### Access Container Shell
```bash
# Web container
docker exec -it codeigniter_web bash

# Database container
docker exec -it codeigniter_db bash
```

### Database Access via CLI
```bash
docker exec -it codeigniter_db mysql -uroot -proot cartridge
```

## Configuration

### Environment Variables Reference

All configuration is managed through the `.env` file:

```env
# Port Configuration
WEB_PORT=8036              # Web application port
DB_PORT=3389               # MySQL database port
PHPMYADMIN_PORT=8081       # PhpMyAdmin port

# Database Configuration
MYSQL_ROOT_PASSWORD=root   # MySQL root password
MYSQL_DATABASE=cartridge   # Database name
MYSQL_USER=webuser        # Database user
MYSQL_PASSWORD=123        # Database password

# Application Environment
CI_ENV=development        # CodeIgniter environment (development/production)
```

### Database Connection

The database configuration has been updated to support environment variables:
- `application/config/database.php`

The web container automatically receives these environment variables:
- DB_HOST: db (internal Docker network)
- DB_USER: from MYSQL_USER
- DB_PASS: from MYSQL_PASSWORD
- DB_NAME: from MYSQL_DATABASE

### Changing Ports

To change ports, simply edit the `.env` file and restart containers:

```bash
# Edit .env file
nano .env

# Restart containers
docker-compose down
docker-compose up -d
```

## Directory Structure

```
legacy-codeigniter-php5-4/
├── docker-compose.yml                    # Main docker compose configuration
├── docker-compose.override.yml.example   # Override example for custom configs
├── Dockerfile                            # PHP 5.6 + Apache image
├── .env                                  # Environment variables (ports, db config)
├── .env.example                          # Environment variables template
├── DOCKER_SETUP.md                      # This file
├── .dockerignore                        # Files to exclude from build
├── .htaccess                            # Apache rewrite rules
├── application/                         # CodeIgniter application
│   ├── config/                         # Configuration files
│   │   └── database.php                # DB config (uses env vars)
│   ├── controllers/                    # Controllers
│   ├── models/                         # Models
│   └── views/                          # Views
├── system/                              # CodeIgniter framework
├── DB/                                  # SQL init files (auto-imported)
└── index.php                            # Entry point
```

## Troubleshooting

### Container won't start
```bash
# Check logs
docker-compose logs

# Remove and rebuild
docker-compose down -v
docker-compose up -d --build
```

### Database connection issues
1. Verify database container is running: `docker-compose ps`
2. Check database logs: `docker-compose logs db`
3. Verify hostname is set to 'db' in database config

### Permission issues
```bash
# Fix permissions
docker exec -it codeigniter_web chown -R www-data:www-data /var/www/html
```

### Clear cache and sessions
```bash
docker exec -it codeigniter_web bash
cd /var/www/html/application/cache
rm -rf *
```

## PHP Extensions Installed

- gd (for image manipulation)
- mysqli (MySQL database driver)
- pdo_mysql (PDO MySQL driver)
- zip (for archive handling)

## Notes

- PHP 5.6 is EOL (End of Life) and should only be used for legacy applications
- Consider migrating to PHP 7.4+ or PHP 8.x when possible
- The application runs in development mode by default (errors are displayed)
- For production, change CI_ENV to 'production'

## Migration Path

This setup is designed for legacy support. Consider:
1. Upgrading to CodeIgniter 4
2. Migrating to modern PHP (8.1+)
3. Implementing modern security practices
4. Using composer for dependency management
