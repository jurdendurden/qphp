<?php 

$username = "";
$password = "";
$password_err = "";
$username_err = "";

/*if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    //take post information and do something with it.
}*/

?>

<main>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <div>
            <label>Username: </label>
            <input type="text" name="username" value="<?php echo $username; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
        </div>    
        <div>
            <label>Password: </label>
            <input type="password" name="password">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
        </div>
        <div>
            <input type="submit" class="btn" value="Login">
        </div>
        <p>Don't have an account? <a href="view/register.php">Sign up now</a></p>
        <p>Forgot password? <a href="reset_password.php">Password Recovery</a></p>
        <p>Forgot username? <a href="forgot_username.php">Username Recovery</a></p>
    </form>
</main>


