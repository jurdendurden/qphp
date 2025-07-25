<?php 
/**
 * QPHP Application Entry Point & Router
 * 
 * This file serves as the main entry point for the QPHP MVC application.
 * It handles routing, session management, includes, and application bootstrapping.
 * 
 * Features:
 * - Hybrid routing system (path-based and query parameter)
 * - Session management and authentication state
 * - Error handling and debugging
 * - Subdirectory support for flexible deployment
 * 
 * @package QPHP
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 */

// =============================================================================
// APPLICATION BOOTSTRAP
// =============================================================================

/**
 * Include Core Components
 * Load essential application components in proper order
 */
include('view/header.php');  // HTML head, CSS, theme toggle, opening body
include('config/config.php'); // Application configuration and constants

/**
 * Session Management
 * Initialize PHP session for user authentication and state management
 */
session_start(); 

/**
 * Development Configuration
 * Enable strict error reporting and display for development environment
 * 
 * @todo Remove or modify for production deployment
 */
// declare(strict_types=1); // Uncomment for strict type checking
error_reporting(-1);           // Report all errors
ini_set('display_errors', 'true'); // Display errors on screen

/**
 * Default Authentication State
 * Set default logged-in state to false for security
 * 
 * @todo Implement proper session-based authentication checking
 */
$_SESSION['logged_in'] = false;

// =============================================================================
// ROUTING SYSTEM
// =============================================================================

/**
 * URL Parsing and Route Preparation
 * 
 * Parse the incoming request URI to handle both query parameters
 * and path-based routing. This system supports:
 * - Clean URLs with query parameters (?page=register)
 * - Direct file access (/view/register.php)
 * - Subdirectory installations (/qphp/view/register.php)
 */

// Get the raw REQUEST_URI from the server
$request_uri = $_SERVER['REQUEST_URI'];

// Parse URL to separate path from query string
$request = parse_url($request_uri, PHP_URL_PATH);

// Normalize path by removing leading/trailing slashes
$request = trim($request, '/');

/**
 * Query Parameter Handling
 * Extract 'page' parameter for clean URL routing
 * Example: /?page=register becomes $page = 'register'
 */
$page = isset($_GET['page']) ? $_GET['page'] : '';

/**
 * Debug Information
 * Display routing information in HTML comments for development debugging
 * These comments are visible in browser source but not rendered
 * 
 * @todo Remove or disable for production
 */
echo "<!-- DEBUG: REQUEST_URI = " . htmlspecialchars($request_uri) . " -->\n";
echo "<!-- DEBUG: Parsed path = " . htmlspecialchars($request) . " -->\n";
echo "<!-- DEBUG: Page parameter = " . htmlspecialchars($page) . " -->\n";

// =============================================================================
// ROUTE HANDLING
// =============================================================================

/**
 * Hybrid Routing System
 * 
 * This application supports two routing methods:
 * 1. Query Parameter Routing (Recommended): /?page=register
 * 2. Path-Based Routing (Legacy): /view/register.php
 * 
 * Query parameter routing takes precedence over path-based routing
 */

if (!empty($page)) {
    /**
     * Query Parameter Routing
     * 
     * Handle clean URLs using query parameters
     * This method provides better SEO and cleaner URLs
     */
    switch ($page) {
        case 'register':
            /**
             * User Registration Page
             * Display registration form for new users
             */
            require 'view/register.php';
            break;
            
        case 'reset_password':
            /**
             * Password Recovery Page
             * Allow users to reset forgotten passwords
             */
            require 'view/reset_password.php';
            break;
            
        case 'forgot_username':
            /**
             * Username Recovery Page
             * Help users recover forgotten usernames
             */
            require 'view/forgot_username.php';
            break;
            
        default:
            /**
             * Invalid Page Parameter
             * Handle unknown page parameters with 404 error
             */
            http_response_code(404);
            echo '<title>404 Error</title>';
            echo "<!-- DEBUG: Unknown page parameter '$page' -->\n";
            require 'view/404.php';
            break;
    }
    
} else {
    /**
     * Path-Based Routing
     * 
     * Handle traditional file-path based routing
     * Supports both root installation and subdirectory installation
     */
    switch ($request) {
        case '':
        case 'index.php':
        case 'qphp':
        case 'qphp/index.php':    
        case 'view/login.php':
            /**
             * Home/Login Route
             * 
             * Application entry point that displays:
             * - Login page for unauthenticated users
             * - Dashboard/home page for authenticated users
             * 
             * @todo Implement proper authentication checking
             */
            if (!$_SESSION['logged_in']) {
                require 'view/login.php';
            } else {
                require 'view/home.php';
            }
            break;

        case 'view/reset_password.php':
        case 'qphp/view/reset_password.php':
            /**
             * Password Reset Route (Path-based)
             * Legacy support for direct file access
             */
            require 'view/reset_password.php';
            break;

        case 'view/register.php':
        case 'qphp/view/register.php':
            /**
             * Registration Route (Path-based)
             * Legacy support for direct file access
             */
            require 'view/register.php';
            break;

        case 'view/forgot_username.php':
        case 'qphp/view/forgot_username.php':
            /**
             * Username Recovery Route (Path-based)
             * Legacy support for direct file access
             */
            require 'view/forgot_username.php';
            break;

        default:        
            /**
             * 404 Not Found
             * 
             * Handle all unmatched routes with custom 404 page
             * Provides user-friendly error message and navigation options
             */
            http_response_code(404);
            echo '<title>404 Error</title>';
            echo "<!-- DEBUG: No route matched '$request' -->\n";
            require 'view/404.php';
            break;
    }
}

?>

<?php 
/**
 * Application Footer
 * Include footer component with closing HTML tags
 * This must be the last include in the application
 */
include('view/footer.php') 
?>

<?php
/**
 * ROUTING CONFIGURATION NOTES
 * 
 * Adding New Routes:
 * 1. For query parameter routes: Add new case in the $page switch statement
 * 2. For path-based routes: Add new case in the $request switch statement
 * 3. Create corresponding view file in /view/ directory
 * 4. Update navigation links in other view files
 * 
 * Route Priority:
 * 1. Query parameter routes (?page=xxx) are checked first
 * 2. Path-based routes are fallback for legacy support
 * 3. Default route (home/login) handles empty requests
 * 4. 404 handler catches all unmatched routes
 * 
 * Subdirectory Support:
 * The routing system automatically handles subdirectory installations by:
 * - Checking for 'qphp/' prefix in path-based routes
 * - Normalizing paths with trim() function
 * - Supporting both root and subdirectory access patterns
 * 
 * Security Considerations:
 * - All routes use require (not include) to ensure proper error handling
 * - Debug information is only displayed in HTML comments
 * - Session state is checked before serving protected content
 * - Input sanitization with htmlspecialchars() for debug output
 */
?>