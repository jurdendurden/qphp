<?php
/**
 * Application Header Component
 * 
 * This file contains the HTML head section, navigation header, and theme toggle functionality.
 * It's included at the beginning of every page to ensure consistent styling and navigation.
 * 
 * Features:
 * - HTML5 doctype and meta tags
 * - CSS stylesheet inclusion
 * - Responsive viewport configuration
 * - Theme toggle button with JavaScript
 * - LocalStorage-based theme persistence
 * - Application branding and navigation
 * 
 * @package QPHP\Views
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 */
?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generic MVC PHP Application</title>    
    <link rel='stylesheet' href='view/css/main.css'>
</head>
<body>

<header>
    <div class="header-content">
        <div class="logo">
            <a href="../index.php">QPHP App</a>
        </div>
        <button class="theme-toggle" onclick="toggleTheme()" id="theme-toggle">
            🌙 Dark Mode
        </button>
    </div>
</header>

<script>
/**
 * Theme Toggle Functionality
 * 
 * Provides light/dark mode switching with persistence using localStorage.
 * The theme state is maintained across page refreshes and browser sessions.
 */

/**
 * Toggle Theme Function
 * 
 * Switches between light and dark themes by manipulating the data-theme
 * attribute on the body element. Updates button text and saves preference.
 */
function toggleTheme() {
    const body = document.body;
    const themeToggle = document.getElementById('theme-toggle');
    
    if (body.getAttribute('data-theme') === 'dark') {
        // Switch to light mode
        body.removeAttribute('data-theme');
        themeToggle.innerHTML = '🌙 Dark Mode';
        localStorage.setItem('theme', 'light');
    } else {
        // Switch to dark mode
        body.setAttribute('data-theme', 'dark');
        themeToggle.innerHTML = '☀️ Light Mode';
        localStorage.setItem('theme', 'dark');
    }
}

/**
 * Theme Initialization
 * 
 * Loads the saved theme preference from localStorage when the page loads.
 * This ensures the user's theme choice persists across sessions.
 */
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme');
    const themeToggle = document.getElementById('theme-toggle');
    
    if (savedTheme === 'dark') {
        document.body.setAttribute('data-theme', 'dark');
        themeToggle.innerHTML = '☀️ Light Mode';
    } else {
        themeToggle.innerHTML = '🌙 Dark Mode';
    }
});
</script>