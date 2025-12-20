<?php
$BASE_URL = 'http://localhost/MagangInAja/';
$BASE_PATH = __DIR__ . '/';

$host = 'localhost';
$username = 'root';
$password = '';
$dbname = 'magang';

$conn = mysqli_connect($host, $username, $password, $dbname);
if (mysqli_connect_errno()) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>