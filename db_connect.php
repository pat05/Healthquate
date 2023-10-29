<?php
require 'vendor/autoload.php';

// Load .env file
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$dbHost = $_ENV['DB_HOST'];
$dbUser = $_ENV['DB_USER'];
$dbPass = $_ENV['DB_PASS'];
$dbname = $_ENV['DB_NAME'];

$connection = mysqli_connect($dbHost, $dbUser, $dbPass, $dbname);
if (!$connection) {
    die("connection failed:" . mysqli_connect_error());
}
