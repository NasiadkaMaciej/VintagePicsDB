<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
</head>

<body>
    <h1>Registration</h1>
    <?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get user input
        $username = $_POST["username"];
        #$email = $_POST["email"];
        $password = $_POST["password"];

        // Hash the password (for security)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Database connection (use your own database credentials)
        require_once('db_config.php');
        $connection = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        // Check if the username or email already exists in the database
        $checkQuery = "SELECT * FROM users WHERE username = ?"; #OR email = ?";
        $stmt = $connection->prepare($checkQuery);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            #echo "Username or email already exists. Please choose a different one.";
            echo "Username already exists. Please choose a different one.";
        } else {
            // Insert the new user into the database
            #$insertQuery = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
            $insertQuery = "INSERT INTO users (username, password) VALUES (?, ?)";
            $stmt = $connection->prepare($insertQuery);
            #$stmt->bind_param("sss", $username, $email, $hashedPassword);
            $stmt->bind_param("ss", $username, $hashedPassword);

            if ($stmt->execute()) {
                echo "Registration successful. You can now <a href='login.php'>login</a>.";
            } else {
                echo "Error: " . $stmt->error;
            }
        }

        // Close the database connection
        $stmt->close();
        $connection->close();
    }
    ?>

    <form action="" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <!--
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required><br><br>
        -->
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Register">
    </form>
</body>

</html>