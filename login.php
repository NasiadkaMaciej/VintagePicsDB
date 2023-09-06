<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    require_once('db_config.php');
    $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

    if (isset($_POST['username']) && isset($_POST['password'])) {
        $entered_username = $_POST['username'];
        $entered_password = $_POST['password'];

        // Query to fetch user from the database
        $sql = "SELECT * FROM users WHERE username = '$entered_username'";
        $result = $connection->query($sql);

        if ($result->num_rows == 1) {
            $row = $result->fetch_assoc();
            $stored_password = $row['password'];

            if (password_verify($entered_password, $stored_password)) {
            #if ($entered_password == $stored_password) {
                // Authentication successful.
                $_SESSION['username'] = $_POST['username'];
                header("Location: index.php"); // Redirect to a welcome or protected page.
                exit();
            } else {
                // Authentication failed.
                echo "Invalid username or password. Please try again.";
            }
        } else {
            // User not found.
            echo "User not found. Please try again.";
        }
    }

    $connection->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>

    <h2>Login</h2>

    <form method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Log In">
    </form>

</body>

</html>