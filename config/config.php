<?php
/**
 * QPHP Application Configuration File
 * 
 * This file contains all the core configuration settings for the QPHP MVC application.
 * It defines application constants, database connection parameters, and global settings.
 * 
 * @package QPHP
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 */

// =============================================================================
// APPLICATION CONFIGURATION
// =============================================================================

/**
 * Application version number
 * Used for cache busting, API versioning, and display purposes
 */
$GLOBALS["version"] = 1.0;

/**
 * Application Root Directory
 * Defines the absolute path to the application root directory
 * Used for file includes and path resolution
 */
define('APP_ROOT', dirname(dirname(__FILE__)));

/**
 * URL Root Configuration
 * Defines the base URL path for the application
 * Change this if your application is hosted in a subdirectory
 * 
 * Examples:
 * - For root installation: '/'
 * - For subdirectory: '/myapp/'
 */
define('URL_ROOT', '/');

/**
 * URL Subfolder Configuration
 * Additional subfolder path if needed for complex hosting setups
 * Usually left empty for standard installations
 */
define('URL_SUBFOLDER', '');

// =============================================================================
// DATABASE CONFIGURATION
// =============================================================================

/**
 * Database Host
 * The hostname or IP address of your MySQL/MariaDB server
 * Common values: 'localhost', '127.0.0.1', or remote server IP
 */
define('DB_HOST', 'localhost');

/**
 * Database Username
 * The username for database authentication
 * Default: 'root' (change this for production environments)
 */
define('DB_USER', 'root');

/**
 * Database Password
 * The password for database authentication
 * IMPORTANT: Set a strong password for production environments
 */
define('DB_PASS', '');

/**
 * Database Name
 * The name of the database to connect to
 * Update this with your actual database name once created
 */
define('DB_NAME', '');

// =============================================================================
// DATABASE CONNECTION
// =============================================================================

/**
 * PDO Database Connection Setup
 * 
 * This section handles the database connection using PDO (PHP Data Objects)
 * Currently commented out until database is properly configured
 * 
 * To enable database functionality:
 * 1. Create a MySQL/MariaDB database
 * 2. Update DB_NAME constant above
 * 3. Uncomment the code below
 * 4. Run database migrations/setup scripts
 * 
 * Error handling:
 * - Connection errors are caught and displayed
 * - Application redirects to error page on database failure
 * - Error messages are logged for debugging
 */

/*
try {
    // Create PDO connection with error handling
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $db = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // Log the error for debugging (implement proper logging in production)
    error_log('Database Connection Error: ' . $e->getMessage());
    
    // Set user-friendly error message
    $error_message = 'Database connection failed. Please try again later.';
    
    // In development, show detailed error (remove for production)
    if (ini_get('display_errors')) {
        $error_message = 'Database Error: ' . $e->getMessage();
    }
    
    // Display error and stop execution
    include(APP_ROOT . '/view/error.php');
    exit();
}
*/

// =============================================================================
// ADDITIONAL CONFIGURATION OPTIONS
// =============================================================================

/**
 * Application Environment Settings
 * 
 * Uncomment and configure these settings based on your environment:
 */

// Timezone Configuration
// date_default_timezone_set('America/New_York');

// Session Configuration
// ini_set('session.cookie_lifetime', 0); // Session expires when browser closes
// ini_set('session.use_only_cookies', 1); // Only use cookies for sessions
// ini_set('session.cookie_secure', 1);    // Enable for HTTPS only
// ini_set('session.cookie_httponly', 1);  // Prevent JavaScript access to session cookies

// Error Reporting Configuration (Development vs Production)
// For Development:
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// For Production:
// error_reporting(0);
// ini_set('display_errors', 0);
// ini_set('log_errors', 1);
// ini_set('error_log', APP_ROOT . '/logs/error.log');

/**
 * Security Configuration
 * 
 * Additional security headers and configurations:
 */

// Security Headers (uncomment for production)
// header('X-Content-Type-Options: nosniff');
// header('X-Frame-Options: DENY');
// header('X-XSS-Protection: 1; mode=block');
// header('Strict-Transport-Security: max-age=31536000; includeSubDomains');

?>