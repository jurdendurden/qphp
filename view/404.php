<?php
/**
 * 404 Not Found Error Page
 * 
 * This page is displayed when users attempt to access non-existent routes or pages.
 * It provides a user-friendly error message and navigation options to help users
 * find what they're looking for.
 * 
 * Features:
 * - User-friendly error message
 * - Clear navigation back to home
 * - Consistent styling with the rest of the application
 * - SEO-friendly 404 response
 * - Responsive design
 * 
 * @package QPHP\Views
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 * @todo Add search functionality for missing pages
 * @todo Add popular pages suggestions
 * @todo Add error logging for broken links
 * @todo Add breadcrumb navigation
 */
?>
<main>
    <div class="error-container">
        <h1>404</h1>
        <p>Oops! You've reached the end of the internet!</p>
        <p>The page you're looking for doesn't exist.</p>
        <div class="mt-4">
            <a href="../index.php" class="btn btn-primary">Go Back Home</a>
        </div>
    </div>
</main>