<?php
session_start();
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: register.php");
    exit;
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];
$address = trim($_POST['address'] ?? '');

// Save old values for repopulating form
$_SESSION['old_username'] = $username;
$_SESSION['old_email'] = $email;

// Validation
if (empty($username) || empty($email) || empty($password) || empty($confirm)) {
    $_SESSION['error'] = "Täytä kaikki kentät.";
    header("Location: register.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Sähköpostiosoite ei kelpaa.";
    header("Location: register.php");
    exit;
}

if ($password !== $confirm) {
    $_SESSION['error'] = "Salasanat eivät täsmää.";
    header("Location: register.php");
    exit;
}

if (strlen($password) < 6) {
    $_SESSION['error'] = "Salasanan tulee olla vähintään 6 merkkiä.";
    header("Location: register.php");
    exit;
}

// Check if email exists
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
$stmt->execute([$email]);

if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = "Sähköposti on jo käytössä.";
    header("Location: register.php");
    exit;
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Insert user with default role = "user"
$stmt = $pdo->prepare("INSERT INTO users (name, email, password, role, address) VALUES (?, ?, ?, 'user', ?)");
$stmt->execute([$username, $email, $hashed, $address]);

// Clear old values after success
unset($_SESSION['old_username']);
unset($_SESSION['old_email']);

$_SESSION['success'] = "Tili luotu onnistuneesti! Voit nyt kirjautua sisään.";
header("Location: log_in.php");
exit;
?>
