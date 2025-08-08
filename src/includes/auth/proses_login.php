<?php
include 'db.php';

$username = $_POST['username'];
$password = $_POST['password'];

$query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    $user = mysqli_fetch_assoc($result);
    $role = $user['role'];

    // Redirect berdasarkan role
    if ($role === 'admin') {
        header("Location: dashboard-admin.html");
    } elseif ($role === 'pasien') {
        header("Location: dashboard-user.html");
    } else {
        echo "<script>alert('Role tidak dikenali.'); window.location.href='login.html';</script>";
    }
} else {
    echo "<script>alert('Login gagal! Periksa kembali ID dan Password.'); window.location.href='login.html';</script>";
}
?>
