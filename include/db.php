<?php
$config = require __DIR__ . '/../config.php';

$mysqli = new mysqli(
    $config['host'],
    $config['username'],
    $config['password'],
    $config['database'],
    $config['port']
);

if ($mysqli->connect_errno) {
    die("Failed to connect to MySQL: " . $mysqli->connect_error);
}
?>
