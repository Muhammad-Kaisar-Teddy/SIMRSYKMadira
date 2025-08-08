<?php
$host = "localhost";
$user = "root"; // default user di XAMPP
$pass = "";     // default XAMPP tanpa password
$db   = "simrs_db";

// Koneksi MySQLi (untuk file lama)
$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi MySQLi gagal: " . mysqli_connect_error());
}

// Koneksi PDO (untuk API baru)
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch(PDOException $e) {
    die("Koneksi PDO gagal: " . $e->getMessage());
}
?>
