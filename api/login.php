<?php
session_start();
header('Content-Type: application/json');
require_once '../db.php';

// hanya terima POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(['ok'=>false,'msg'=>'Method not allowed']);
  exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$sql = "SELECT id, username, password_hash, role FROM users WHERE username = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($res);

if (!$user || !password_verify($password, $user['password_hash'])) {
  echo json_encode(['ok'=>false, 'msg'=>'ID atau password salah']);
  exit;
}

$_SESSION['user_id'] = $user['id'];
$_SESSION['username']= $user['username'];
$_SESSION['role']    = $user['role'];

echo json_encode(['ok'=>true, 'role'=>$user['role']]);
