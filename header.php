<div id="header">
    <div id="login-register">
        <?php
        if (isset($_SESSION['username'])) {
            echo "Welcome " . $_SESSION['username'] . " ";
            // User is logged in.
            echo '<a href="logout.php">Log Out</a>';
        } else {
            // User is not logged in.
            echo '<a href="login.php">Log In</a> | <a href="register.php">Register</a>';
        }
        ?>
    </div>
</div>