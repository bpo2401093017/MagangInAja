<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'magang';

$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$base_url = "http://localhost/MagangInAja/";
$base_path = __DIR__ . '/';
