<?php

$hostname = "localhost";
$username = "root";
$password = "";
$database = "charity_db";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("connection error - " . $conn->connect_error);
}

if (!isset($_SESSION)) {
    session_start();
}
