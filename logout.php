<?php
session_start();

unset($_SESSION["username"]);
header("Location: index.php"); // Redirect to a welcome or protected page.
