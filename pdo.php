<?php

$hostname = 'sql1.njit.edu';
$username = 'bcn3_proj';
$password = 'w9hLvRFP';
$dsn = "mysql:host=$hostname;dbname=$username";

try {
    $db = new PDO($dsn, $username, $password);
} catch (PDOException $error) {
    $error_message = $error->getMessage();
    echo "Error connecting to SQL: $error_message";
}