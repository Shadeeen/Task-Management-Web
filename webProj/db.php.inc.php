<?php

$db_host = 'localhost:3306';
$db_name = 'web1220169_atp';
$db_user = 'web1220169_shaden';
$db_pass = '0524568466SH.';

try {
    $connection = "mysql:host=$db_host;dbname=$db_name";
    $pdo = new PDO($connection, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
