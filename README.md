# QPHP - Modern PHP MVC Application

A lightweight, modern PHP MVC application with advanced theming capabilities, responsive design, and comprehensive documentation. Built following modern PHP practices and web standards.

## ✨ Features

### 🎨 Modern UI/UX
- **Light & Dark Mode Toggle**: Seamlessly switch between themes from any page with localStorage persistence
- **Responsive Design**: Optimized for desktop, tablet, and mobile devices with CSS Grid and Flexbox
- **Modern Typography**: Uses system font stack for optimal performance and readability
- **Consistent Styling**: Centralized CSS architecture with CSS custom properties (CSS variables)
- **Smooth Animations**: Transition effects for theme switching and interactive elements

### 🔐 User Authentication System
- User registration with comprehensive form validation
- Secure login functionality with session management
- Password recovery system with email verification
- Username recovery system
- Session security and CSRF protection
- XSS prevention with input sanitization

### 🛠️ Technical Features
- **MVC Architecture**: Clean separation of concerns with dedicated models, views, and controllers
- **Hybrid Routing System**: Supports both path-based and query parameter routing
- **Error Handling**: Custom 404 and error pages with user-friendly messages
- **Debug Mode**: Built-in debugging with detailed routing information
- **Form Validation**: Client-side and server-side validation framework
- **Database Ready**: PDO-based database layer with prepared statements
- **Security Features**: CSRF protection, XSS prevention, input sanitization

## 🎯 Theme System

### Light/Dark Mode Toggle
The application features a sophisticated theme system with:
- **Persistent Preferences**: Theme choice automatically saved in localStorage
- **Smooth Transitions**: Animated transitions between light and dark themes
- **CSS Custom Properties**: Modern variable-based styling for easy customization
- **Global Accessibility**: Theme toggle available on every page via header navigation
- **System Integration**: Respects user's OS theme preferences (can be extended)

### Color Schemes
**Light Mode:**
- Clean, professional appearance with high contrast
- Blue accent colors (#007bff) for optimal accessibility
- White backgrounds with subtle gray borders

**Dark Mode:**
- Easy on the eyes for low-light environments
- Enhanced blue accents (#4dabf7) for better dark-mode visibility
- Dark gray backgrounds with consistent contrast ratios

## 📁 Project Structure

```
qphp/
├── config/
│   └── config.php              # Application and database configuration
├── model/
│   └── user.php               # User model with CRUD operations
├── view/
│   ├── css/
│   │   └── main.css           # Centralized styling system
│   ├── header.php             # Header with navigation and theme toggle
│   ├── footer.php             # Footer component
│   ├── login.php              # User login page
│   ├── register.php           # User registration page
│   ├── home.php               # Dashboard/home page for authenticated users
│   ├── reset_password.php     # Password recovery page
│   ├── forgot_username.php    # Username recovery page
│   ├── error.php              # General error display page
│   └── 404.php                # 404 not found error page
├── index.php                  # Main application router and entry point
├── README.md                  # This documentation file
└── .htaccess                  # Apache configuration (if needed)
```

## 🚀 Getting Started

### Prerequisites
- **PHP**: Version 7.4 or higher (PHP 8.0+ recommended)
- **Web Server**: Apache, Nginx, or PHP built-in server
- **Database**: MySQL 5.7+ or MariaDB 10.2+ (optional, for full functionality)
- **Browser**: Modern browser with JavaScript enabled

### Installation

#### Option 1: Local Development Server
```bash
# Clone or download the project
git clone <repository-url> qphp
cd qphp

# Start PHP built-in server
php -S localhost:8000

# Access application at http://localhost:8000
```

#### Option 2: Apache/Nginx Installation
```bash
# Copy files to web server directory
cp -r qphp/ /var/www/html/qphp/

# Set proper permissions
chmod -R 755 /var/www/html/qphp/
chown -R www-data:www-data /var/www/html/qphp/

# Access application at http://localhost/qphp/
```

### Database Setup (Optional)

#### 1. Create Database
```sql
CREATE DATABASE qphp_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 2. Create Users Table
```sql
USE qphp_app;

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
    INDEX idx_email (email)
);
```

#### 3. Configure Database Connection
Edit `config/config.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'your_username');
define('DB_PASS', 'your_password');
define('DB_NAME', 'qphp_app');

// Uncomment the database connection code
```

### Development Setup

#### 1. Enable Development Mode
In `index.php`, ensure these lines are present:
```php
error_reporting(-1);
ini_set('display_errors', 'true');
```

#### 2. Check Debug Information
- View HTML source to see routing debug comments
- Check browser console for any JavaScript errors
- Monitor server error logs for PHP issues

#### 3. File Permissions
Ensure web server has read access to all files:
```bash
find . -type f -exec chmod 644 {} \;
find . -type d -exec chmod 755 {} \;
```

## 🎨 Styling Architecture

### CSS Custom Properties System
The application uses CSS custom properties for comprehensive theming:

```css
:root {
    --bg-color: #ffffff;
    --text-color: #333333;
    --primary-bg: #f8f9fa;
    --secondary-bg: #e9ecef;
    --border-color: #dee2e6;
    --accent-color: #007bff;
    --accent-hover: #0056b3;
    /* ... more variables */
}

[data-theme="dark"] {
    --bg-color: #1a1a1a;
    --text-color: #e0e0e0;
    --primary-bg: #2d2d2d;
    /* ... dark mode overrides */
}
```

### Component Classes
- **Buttons**: `.btn`, `.btn-primary`, `.btn-secondary`
- **Forms**: `.form-buttons`, `.invalid-feedback`
- **Layout**: `.welcome-container`, `.error-container`
- **Navigation**: `.nav-links`, `.header-content`
- **Utilities**: `.mt-1` through `.mt-4`, `.mb-1` through `.mb-4`

### Responsive Breakpoints
- **Desktop**: `> 768px` - Full multi-column layout
- **Tablet/Mobile**: `≤ 768px` - Single-column stacked layout

## 🔧 Routing System

### Query Parameter Routing (Recommended)
Clean URLs using query parameters:
- **Home/Login**: `http://localhost/qphp/`
- **Register**: `http://localhost/qphp/?page=register`
- **Password Reset**: `http://localhost/qphp/?page=reset_password`
- **Username Recovery**: `http://localhost/qphp/?page=forgot_username`

### Path-Based Routing (Legacy Support)
Direct file access for backward compatibility:
- **Register**: `http://localhost/qphp/view/register.php`
- **Password Reset**: `http://localhost/qphp/view/reset_password.php`

### Adding New Routes
1. **Query Parameter Route**: Add new case in `$page` switch statement in `index.php`
2. **Create View File**: Add corresponding PHP file in `/view/` directory
3. **Update Navigation**: Add links in other view files as needed

## 🔐 Security Features

### Input Validation & Sanitization
- **XSS Protection**: `htmlspecialchars()` used throughout
- **CSRF Protection**: Form action validation with `$_SERVER["PHP_SELF"]`
- **Input Validation**: Client-side and server-side validation framework
- **SQL Injection Prevention**: PDO prepared statements with parameter binding

### Session Security
- Secure session configuration options in `config/config.php`
- Session timeout handling (ready for implementation)
- Authentication state management
- Session regeneration for security

### Security Headers (Production Ready)
Uncomment in `config/config.php` for production:
```php
header('X-Content-Type-Options: nosniff');
header('X-Frame-Options: DENY');
header('X-XSS-Protection: 1; mode=block');
header('Strict-Transport-Security: max-age=31536000; includeSubDomains');
```

## 🧪 Development Guidelines

### Code Style
- **PHP**: Follow PSR-1 and PSR-2 standards
- **Documentation**: Comprehensive PHPDoc comments
- **Naming**: Use snake_case for variables, PascalCase for classes
- **Security**: Always sanitize input and validate data

### Adding New Features
1. **Plan Database Changes**: Update schema and model classes
2. **Create Views**: Add new PHP files in `/view/` directory with proper documentation
3. **Update Routes**: Add routing logic in `index.php`
4. **Test Thoroughly**: Check both light and dark themes
5. **Update Documentation**: Update this README and inline docs

### File Organization
- **Models**: Database interaction and business logic
- **Views**: HTML templates and user interface
- **Config**: Application settings and database configuration
- **Assets**: CSS, JavaScript, and other static files

## 📱 Browser Support

### Supported Browsers
- **Chrome**: 70+
- **Firefox**: 65+
- **Safari**: 12+
- **Edge**: 79+

### Required Features
- CSS Custom Properties (CSS Variables)
- LocalStorage API
- Modern JavaScript (ES6+)
- CSS Grid and Flexbox

## 🎯 Future Enhancements

### Planned Features
- [ ] Complete database integration with user authentication
- [ ] Email functionality for password/username recovery
- [ ] Admin panel with user management
- [ ] API endpoints for frontend frameworks
- [ ] Unit testing framework
- [ ] Logging system for errors and security events
- [ ] User profile management
- [ ] Two-factor authentication (2FA)
- [ ] Social login integration
- [ ] File upload functionality

### Performance Optimizations
- [ ] CSS/JS minification for production
- [ ] Image optimization and lazy loading
- [ ] Database query optimization
- [ ] Caching system implementation
- [ ] CDN integration for static assets

## 🐛 Troubleshooting

### Common Issues

#### 1. Database Connection Errors
- Verify database credentials in `config/config.php`
- Ensure database server is running
- Check database user permissions

#### 2. Routing Issues
- Check `.htaccess` file if using Apache
- Verify file permissions (644 for files, 755 for directories)
- Review debug comments in HTML source

#### 3. Theme Toggle Not Working
- Ensure JavaScript is enabled in browser
- Check browser console for JavaScript errors
- Verify localStorage is supported and not disabled

#### 4. Styling Issues
- Clear browser cache
- Check that `view/css/main.css` is accessible
- Verify no CSS syntax errors

### Debug Mode
Enable comprehensive debugging by setting in `index.php`:
```php
error_reporting(E_ALL);
ini_set('display_errors', 1);
```

## 📄 License

This project is open source and available under the [MIT License](LICENSE).

## 🤝 Contributing

Contributions are welcome! Please follow these guidelines:
1. Fork the repository
2. Create a feature branch
3. Follow the code style guidelines
4. Add comprehensive documentation
5. Test thoroughly across browsers
6. Submit a pull request

## 📞 Support

For support and questions:
- Check the troubleshooting section above
- Review the inline code documentation
- Create an issue in the project repository

---

**Built with ❤️ using modern PHP practices and web standards**

*Last updated: 2024 | Version 1.0 | QPHP Development Team*
 
