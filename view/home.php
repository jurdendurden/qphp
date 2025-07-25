<?php 
/**
 * User Dashboard/Home Page
 * 
 * This page displays the main dashboard for authenticated users. It serves as
 * the landing page after successful login and provides navigation to user functions.
 * 
 * Features:
 * - User authentication verification
 * - Welcome message and user information
 * - Dashboard navigation options
 * - Logout functionality
 * - Responsive dashboard layout
 * - Session security checks
 * 
 * @package QPHP\Views
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 * @todo Add user profile information display
 * @todo Implement dashboard widgets
 * @todo Add user activity feed
 * @todo Add quick action buttons
 */

/**
 * Authentication Check
 * 
 * Verify that the user is properly authenticated before displaying the dashboard.
 * Redirect to login page if user is not logged in.
 * 
 * @todo Implement proper session-based authentication
 * @todo Add additional security checks (session timeout, etc.)
 */
if (!$_SESSION['logged_in']) {
    header('Location: /');
    exit();
}

?>

<main>
    <div class="welcome-container">
        <h1>Welcome to your Dashboard!</h1>
        <p>You are successfully logged in.</p>
        
        <div class="dashboard-actions">
            <a href="/logout" class="btn btn-primary">Logout</a>
            <a href="/profile" class="btn btn-secondary">View Profile</a>
        </div>
    </div>
</main> 