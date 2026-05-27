<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: log_in.php");
    exit;
}

$email = trim($_POST['email']);
$password = $_POST['password'];

// Save old email for repopulating form
$_SESSION['old_email'] = $email;

// Fetch user
$stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    $_SESSION['error'] = "Sähköposti tai salasana on virheellinen.";
    header("Location: log_in.php");
    exit;
}

// Verify password
if (!password_verify($password, $user['password'])) {
    $_SESSION['error'] = "Sähköposti tai salasana on virheellinen.";
    header("Location: log_in.php");
    exit;
}

// Login success
$_SESSION['user_id'] = $user['id'];
$_SESSION['username'] = $user['username'];
$_SESSION['role'] = $user['role'];

// Redirect based on role
if ($user['role'] === "admin") {
    header("Location: admin/index.php");
} else {
    header("Location: menu.php");
}
exit;
?>
