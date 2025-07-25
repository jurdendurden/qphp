<?php
/**
 * General Error Display Page
 * 
 * This page displays various application errors in a user-friendly format.
 * It's used for database errors, configuration issues, and other system errors
 * that need to be presented to the user.
 * 
 * Features:
 * - Dynamic error message display
 * - Consistent error styling
 * - Safe error message handling with XSS protection
 * - Navigation back to application
 * - Responsive error layout
 * 
 * @package QPHP\Views
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 * @todo Add error categorization (warning, error, critical)
 * @todo Add error reporting functionality
 * @todo Add contact support options
 * @todo Add error code system
 */
?>
<main>
    <div class="error-container">
        <h1>Error</h1>
        <div class="error-message">
            <?= isset($error_message) ? htmlspecialchars($error_message) : 'An unexpected error occurred.' ?>
        </div>
        <div class="mt-4">
            <a href="../index.php" class="btn btn-primary">Go Back Home</a>
        </div>
    </div>
</main>