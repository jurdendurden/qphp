<?php
/**
 * User Model Class
 * 
 * This class handles all user-related database operations including CRUD operations
 * for user management, authentication, and user data retrieval.
 * 
 * @package QPHP\Models
 * @version 1.0
 * @author QPHP Development Team
 * @since 1.0.0
 */

/**
 * Class User
 * 
 * Represents a user entity and provides methods for user data manipulation
 * in the database. This class follows the Active Record pattern for
 * database interactions.
 */
class User
{
    // =============================================================================
    // CLASS PROPERTIES
    // =============================================================================
    
    /**
     * User ID (Primary Key)
     * @var int|null The unique identifier for the user
     */
    public $id;
    
    /**
     * Username
     * @var string|null The user's unique username
     */
    public $name;
    
    /**
     * Email Address
     * @var string|null The user's email address
     */
    public $email;
    
    /**
     * Administrative Privileges
     * @var bool Whether the user has administrative privileges
     */
    public bool $admin;

    // =============================================================================
    // CONSTRUCTOR
    // =============================================================================
    
    /**
     * User Class Constructor
     * 
     * Initializes a new User object. Properties can be set after instantiation
     * or populated through database query methods.
     */
    function __construct()
    {
        // Initialize default values
        $this->id = null;
        $this->name = null;
        $this->email = null;
        $this->admin = false;
    }

    // =============================================================================
    // READ OPERATIONS
    // =============================================================================
    
    /**
     * Select User by Username
     * 
     * Retrieves user data from the database based on username.
     * This method is commonly used for login authentication and user lookups.
     * 
     * @param string $name The username to search for
     * @return array Array of user data or empty array if not found
     * @throws PDOException If database query fails
     * 
     * @example
     * $user = new User();
     * $userData = $user->select_user_by_name('john_doe');
     * if (!empty($userData)) {
     *     echo "User found: " . $userData[0]['email'];
     * }
     */
    function select_user_by_name($name)
    {
        global $db;
        
        $query = 'SELECT id, name, email, admin, created_at, updated_at 
                  FROM users 
                  WHERE name = :name 
                  LIMIT 1';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        return $results;
    }

    /**
     * Select User by ID
     * 
     * Retrieves user data from the database based on user ID.
     * This method is used for user profile retrieval and data updates.
     * 
     * @param int $id The user ID to search for
     * @return array Array of user data or empty array if not found
     * @throws PDOException If database query fails
     * 
     * @example
     * $user = new User();
     * $userData = $user->select_user_by_id(123);
     * if (!empty($userData)) {
     *     $this->name = $userData[0]['name'];
     *     $this->email = $userData[0]['email'];
     * }
     */
    function select_user_by_id($id)
    {
        global $db;
        
        $query = 'SELECT id, name, email, admin, created_at, updated_at 
                  FROM users 
                  WHERE id = :id 
                  LIMIT 1';
        
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $results = $statement->fetchAll();
        $statement->closeCursor();
        
        return $results;
    }

    // =============================================================================
    // CREATE OPERATIONS
    // =============================================================================
    
    /**
     * Insert New User
     * 
     * Creates a new user record in the database with the provided information.
     * This method is used during user registration process.
     * 
     * @param string $name The username for the new user
     * @param bool $admin Whether the user should have admin privileges
     * @return int Number of affected rows (1 if successful, 0 if failed)
     * @throws PDOException If database query fails
     * 
     * @todo Add email parameter and password hashing
     * @todo Add input validation for username format
     * @todo Add duplicate username checking
     * 
     * @example
     * $user = new User();
     * $result = $user->insert_user('new_user', false);
     * if ($result > 0) {
     *     echo "User created successfully";
     * }
     */
    function insert_user($name, $admin)
    {
        global $db;
        
        $count = 0;
        
        $query = 'INSERT INTO users (name, admin, created_at, updated_at)
                  VALUES (:name, :admin, NOW(), NOW())';

        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':admin', $admin, PDO::PARAM_BOOL);
        
        if ($statement->execute()) {
            $count = $statement->rowCount();
            
            // Set the ID of the newly created user
            if ($count > 0) {
                $this->id = $db->lastInsertId();
                $this->name = $name;
                $this->admin = $admin;
            }
        }
        
        $statement->closeCursor();
        return $count;
    }

    // =============================================================================
    // UPDATE OPERATIONS
    // =============================================================================
    
    /**
     * Update User Information
     * 
     * Updates an existing user's information in the database.
     * This method is used for profile updates and administrative changes.
     * 
     * @param string $name The new username
     * @param bool $admin The new admin status
     * @param int $id The ID of the user to update
     * @return int Number of affected rows (1 if successful, 0 if failed)
     * @throws PDOException If database query fails
     * 
     * @todo Add email parameter to update method
     * @todo Add input validation
     * @todo Add check for existing username conflicts
     * 
     * @example
     * $user = new User();
     * $result = $user->update_user('updated_username', true, 123);
     * if ($result > 0) {
     *     echo "User updated successfully";
     * }
     */
    function update_user($name, $admin, $id)
    {
        global $db;
        
        $count = 0;
        
        // Fixed table name from 'user' to 'users' for consistency
        $query = 'UPDATE users 
                  SET name = :name, admin = :admin, updated_at = NOW()
                  WHERE id = :id';

        $statement = $db->prepare($query);
        $statement->bindValue(':name', $name, PDO::PARAM_STR);
        $statement->bindValue(':admin', $admin, PDO::PARAM_BOOL);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        if ($statement->execute()) {
            $count = $statement->rowCount();
            
            // Update local properties if update was successful
            if ($count > 0) {
                $this->id = $id;
                $this->name = $name;
                $this->admin = $admin;
            }
        }
        
        $statement->closeCursor();
        return $count;
    }

    // =============================================================================
    // DELETE OPERATIONS
    // =============================================================================
    
    /**
     * Delete User
     * 
     * Removes a user record from the database permanently.
     * This method should be used with caution as it permanently deletes user data.
     * 
     * @param int $id The ID of the user to delete
     * @return int Number of affected rows (1 if successful, 0 if failed)
     * @throws PDOException If database query fails
     * 
     * @warning This operation is irreversible. Consider implementing soft deletes.
     * @todo Add foreign key constraint handling
     * @todo Add audit logging for user deletions
     * 
     * @example
     * $user = new User();
     * $result = $user->delete_user(123);
     * if ($result > 0) {
     *     echo "User deleted successfully";
     * } else {
     *     echo "User not found or deletion failed";
     * }
     */
    function delete_user($id)
    {
        global $db;
        
        $count = 0;
        
        $query = 'DELETE FROM users WHERE id = :id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        
        if ($statement->execute()) {
            $count = $statement->rowCount();
            
            // Clear local properties if deletion was successful
            if ($count > 0) {
                $this->id = null;
                $this->name = null;
                $this->email = null;
                $this->admin = false;
            }
        }
        
        $statement->closeCursor();
        return $count;
    }

    // =============================================================================
    // UTILITY METHODS
    // =============================================================================
    
    /**
     * Check if User Exists by Username
     * 
     * Utility method to check if a username already exists in the database.
     * Useful for registration validation.
     * 
     * @param string $name The username to check
     * @return bool True if username exists, false otherwise
     * 
     * @example
     * $user = new User();
     * if ($user->username_exists('john_doe')) {
     *     echo "Username already taken";
     * }
     */
    function username_exists($name)
    {
        $result = $this->select_user_by_name($name);
        return !empty($result);
    }
    
    /**
     * Get User's Full Profile
     * 
     * Retrieves complete user information and populates the object properties.
     * 
     * @param int $id The user ID to load
     * @return bool True if user found and loaded, false otherwise
     * 
     * @example
     * $user = new User();
     * if ($user->load_profile(123)) {
     *     echo "Hello, " . $user->name;
     * }
     */
    function load_profile($id)
    {
        $result = $this->select_user_by_id($id);
        
        if (!empty($result)) {
            $userData = $result[0];
            $this->id = $userData['id'];
            $this->name = $userData['name'];
            $this->email = $userData['email'] ?? null;
            $this->admin = (bool)$userData['admin'];
            return true;
        }
        
        return false;
    }
}

/**
 * Recommended Database Schema for Users Table:
 * 
 * CREATE TABLE users (
 *     id INT AUTO_INCREMENT PRIMARY KEY,
 *     name VARCHAR(50) UNIQUE NOT NULL,
 *     email VARCHAR(100) UNIQUE,
 *     password_hash VARCHAR(255),
 *     admin BOOLEAN DEFAULT FALSE,
 *     email_verified BOOLEAN DEFAULT FALSE,
 *     created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
 *     updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
 *     last_login TIMESTAMP NULL,
 *     INDEX idx_name (name),
 *     INDEX idx_email (email)
 * );
 */
?>