# QPHP Installation Guide

This guide provides detailed step-by-step instructions for installing and configuring the QPHP application in various environments.

## 📋 Table of Contents

1. [System Requirements](#system-requirements)
2. [Quick Start](#quick-start)
3. [Development Installation](#development-installation)
4. [Production Installation](#production-installation)
5. [Database Setup](#database-setup)
6. [Configuration](#configuration)
7. [Troubleshooting](#troubleshooting)
8. [Post-Installation](#post-installation)

## 🔧 System Requirements

### Minimum Requirements
- **PHP**: 7.4 or higher
- **Web Server**: Apache 2.4+, Nginx 1.18+, or PHP built-in server
- **Database**: MySQL 5.7+ or MariaDB 10.2+ (optional but recommended)
- **Browser**: Modern browser with JavaScript enabled
- **Disk Space**: 50MB minimum
- **Memory**: 128MB PHP memory limit

### Recommended Requirements
- **PHP**: 8.0 or higher
- **Web Server**: Apache 2.4+ or Nginx 1.20+
- **Database**: MySQL 8.0+ or MariaDB 10.6+
- **Memory**: 256MB PHP memory limit
- **SSL Certificate**: For production environments

### Required PHP Extensions
- `pdo` - Database abstraction layer
- `pdo_mysql` - MySQL database driver
- `session` - Session management
- `json` - JSON handling
- `mbstring` - Multi-byte string support

Check your PHP configuration:
```bash
php -m | grep -E "(pdo|mysql|session|json|mbstring)"
```

## 🚀 Quick Start

For immediate testing and development:

```bash
# Download the application
git clone <repository-url> qphp
cd qphp

# Start PHP built-in server
php -S localhost:8000

# Open in browser
open http://localhost:8000
```

The application will be available immediately with all styling and functionality, but without database features.

## 💻 Development Installation

### Step 1: Download Application
```bash
# Using Git
git clone <repository-url> qphp
cd qphp

# Or download and extract ZIP file
wget <download-url>
unzip qphp.zip
cd qphp
```

### Step 2: Set File Permissions
```bash
# Make files readable by web server
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;

# Ensure index.php is executable
chmod 755 index.php
```

### Step 3: Start Development Server
```bash
# PHP built-in server (recommended for development)
php -S localhost:8000

# Or specify different port
php -S localhost:3000

# Or bind to all interfaces
php -S 0.0.0.0:8000
```

### Step 4: Test Installation
Open your browser and navigate to:
- **Local**: `http://localhost:8000`
- **Network**: `http://[your-ip]:8000`

You should see the login page with theme toggle functionality.

## 🌐 Production Installation

### Apache Installation

#### Step 1: Copy Files
```bash
# Copy to web server directory
sudo cp -r qphp/ /var/www/html/qphp/

# Set ownership
sudo chown -R www-data:www-data /var/www/html/qphp/

# Set permissions
sudo find /var/www/html/qphp/ -type f -exec chmod 644 {} \;
sudo find /var/www/html/qphp/ -type d -exec chmod 755 {} \;
```

#### Step 2: Configure Apache
Create or edit `/etc/apache2/sites-available/qphp.conf`:
```apache
<VirtualHost *:80>
    ServerName qphp.example.com
    DocumentRoot /var/www/html/qphp
    
    <Directory /var/www/html/qphp>
        AllowOverride All
        Require all granted
    </Directory>
    
    ErrorLog ${APACHE_LOG_DIR}/qphp_error.log
    CustomLog ${APACHE_LOG_DIR}/qphp_access.log combined
</VirtualHost>
```

#### Step 3: Enable Site
```bash
sudo a2ensite qphp.conf
sudo a2enmod rewrite headers expires deflate
sudo systemctl reload apache2
```

### Nginx Installation

#### Step 1: Copy Files
```bash
sudo cp -r qphp/ /var/www/html/qphp/
sudo chown -R www-data:www-data /var/www/html/qphp/
```

#### Step 2: Configure Nginx
Create `/etc/nginx/sites-available/qphp`:
```nginx
server {
    listen 80;
    server_name qphp.example.com;
    root /var/www/html/qphp;
    index index.php;

    # Security headers
    add_header X-Content-Type-Options nosniff;
    add_header X-Frame-Options DENY;
    add_header X-XSS-Protection "1; mode=block";

    # PHP processing
    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.0-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Static files caching
    location ~* \.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Deny access to sensitive files
    location ~ /\.(ht|env|log) {
        deny all;
    }
}
```

#### Step 3: Enable Site
```bash
sudo ln -s /etc/nginx/sites-available/qphp /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 🗄️ Database Setup

### Step 1: Create Database
```sql
-- Connect to MySQL/MariaDB as root
mysql -u root -p

-- Create database
CREATE DATABASE qphp_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Create user (replace 'password' with a strong password)
CREATE USER 'qphp_user'@'localhost' IDENTIFIED BY 'your_secure_password';

-- Grant permissions
GRANT ALL PRIVILEGES ON qphp_app.* TO 'qphp_user'@'localhost';
FLUSH PRIVILEGES;

-- Use the database
USE qphp_app;
```

### Step 2: Create Tables
```sql
-- Users table
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE,
    password_hash VARCHAR(255),
    admin BOOLEAN DEFAULT FALSE,
    email_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL,
    
    INDEX idx_name (name),
    INDEX idx_email (email),
    INDEX idx_created_at (created_at)
);

-- Sessions table (optional, for database session storage)
CREATE TABLE sessions (
    id VARCHAR(128) PRIMARY KEY,
    user_id INT,
    data TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    expires_at TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_expires_at (expires_at)
);
```

### Step 3: Create Test User (Optional)
```sql
-- Create a test admin user (password: 'password123')
INSERT INTO users (name, email, password_hash, admin, email_verified) VALUES 
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', TRUE, TRUE);
```

## ⚙️ Configuration

### Step 1: Database Configuration
Edit `config/config.php`:
```php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'qphp_user');
define('DB_PASS', 'your_secure_password');
define('DB_NAME', 'qphp_app');

// Uncomment the database connection code
// Remove the /* and */ around the database connection block
```

### Step 2: Production Settings
For production environments, update `config/config.php`:
```php
// Production error reporting
error_reporting(0);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', APP_ROOT . '/logs/error.log');

// Session security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 1); // Only for HTTPS
```

### Step 3: Security Headers
Uncomment security headers in `config/config.php`:
```php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
```

### Step 4: Create Log Directory
```bash
mkdir -p logs
chmod 755 logs
touch logs/error.log
chmod 644 logs/error.log
```

## 🐛 Troubleshooting

### Common Issues

#### 1. "Permission Denied" Errors
```bash
# Fix file permissions
sudo chown -R www-data:www-data /var/www/html/qphp/
sudo chmod -R 755 /var/www/html/qphp/
```

#### 2. "Database Connection Failed"
- Verify database credentials in `config/config.php`
- Ensure MySQL/MariaDB is running: `sudo systemctl status mysql`
- Test connection: `mysql -u qphp_user -p qphp_app`

#### 3. "404 Not Found" for CSS/Assets
- Check file permissions: `ls -la view/css/main.css`
- Verify web server configuration
- Clear browser cache

#### 4. Theme Toggle Not Working
- Check browser console for JavaScript errors
- Ensure JavaScript is enabled
- Verify localStorage is available

#### 5. "Headers Already Sent" Error
- Check for output before PHP tags
- Ensure no whitespace before `<?php`
- Review error logs: `tail -f logs/error.log`

### Debug Mode
Enable debug mode in `index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

### Check PHP Configuration
```bash
# Check PHP version
php -v

# Check loaded extensions
php -m

# Check PHP configuration
php --ini

# Test PHP configuration
php -r "phpinfo();" | grep -E "(pdo|mysql|session)"
```

## ✅ Post-Installation

### Step 1: Test Core Functionality
1. **Homepage**: Verify login page loads with styling
2. **Theme Toggle**: Test light/dark mode switching
3. **Navigation**: Test all page navigation links
4. **Forms**: Verify form submission (even without backend)
5. **Responsive**: Test on mobile/tablet devices

### Step 2: Verify Database Connection
If database is configured:
```php
// Add to index.php temporarily for testing
try {
    $db = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
```

### Step 3: Security Checklist
- [ ] Change default database password
- [ ] Remove test/debug code
- [ ] Enable security headers
- [ ] Configure SSL certificate (production)
- [ ] Set up regular backups
- [ ] Configure firewall rules
- [ ] Enable fail2ban (if available)

### Step 4: Performance Optimization
- [ ] Enable gzip compression
- [ ] Configure browser caching
- [ ] Optimize images
- [ ] Minify CSS (for production)
- [ ] Set up CDN (if needed)

### Step 5: Monitoring Setup
- [ ] Configure error logging
- [ ] Set up log rotation
- [ ] Monitor disk space
- [ ] Set up uptime monitoring
- [ ] Configure backup scripts

## 📞 Support

If you encounter issues during installation:

1. **Check Requirements**: Verify all system requirements are met
2. **Review Logs**: Check web server and PHP error logs
3. **Test Components**: Test each component individually
4. **Documentation**: Review the main README.md for additional information
5. **Community**: Create an issue in the project repository

---

**Installation Guide Complete!** 🎉

Your QPHP application should now be fully installed and ready for development or production use.

*Last updated: 2024 | QPHP Development Team* 