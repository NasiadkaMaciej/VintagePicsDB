<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>VintagePics</title>
</head>

<body>
    <?php
    session_start();
    include("header.php");
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
    include("browse.php");
    #if logged in
    echo "<br>";
    if (isset($_SESSION['username']))
        include("upload.php");
    else
        echo "Do you want to publish pictures? <a href='register.php'>Create an account</a>
        or
        <a href='login.php'>log in</a>";
    #else
    #"log in?"/"register"?
    #include("login.html");

    ?>
</body>

</html>