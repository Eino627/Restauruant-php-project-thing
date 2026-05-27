<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}

$username = trim($_POST['username']);
$email = trim($_POST['email']);
$new_password = $_POST['new_password'];
$confirm = $_POST['confirm_password'];
$address = trim($_POST['address']);


if (empty($username) || empty($email)) {
    $_SESSION['error'] = "Käyttäjänimi ja sähköposti ovat pakollisia.";
    header("Location: edit_profile.php");
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "Sähköpostiosoite ei kelpaa.";
    header("Location: edit_profile.php");
    exit;
}

// Check if email belongs to someone else
$stmt = $pdo->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
$stmt->execute([$email, $_SESSION['user_id']]);

if ($stmt->rowCount() > 0) {
    $_SESSION['error'] = "Sähköposti on jo käytössä toisella käyttäjällä.";
    header("Location: edit_profile.php");
    exit;
}

$stmt = $pdo->prepare("UPDATE users SET name = ?, email = ?, address = ? WHERE id = ?");
$stmt->execute([$username, $email, $address, $_SESSION['user_id']]);

// Password change (optional)
if (!empty($new_password)) {

    if ($new_password !== $confirm) {
        $_SESSION['error'] = "Uudet salasanat eivät täsmää.";
        header("Location: edit_profile.php");
        exit;
    }

    if (strlen($new_password) < 6) {
        $_SESSION['error'] = "Salasanan tulee olla vähintään 6 merkkiä.";
        header("Location: edit_profile.php");
        exit;
    }

    $hashed = password_hash($new_password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE id = ?");
    $stmt->execute([$hashed, $_SESSION['user_id']]);
}

$_SESSION['success'] = "Tiedot päivitetty onnistuneesti.";
header("Location: profile.php");
exit;
?>
