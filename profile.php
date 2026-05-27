<?php
session_start();
require_once "includes/db.php";

// If not logged in → redirect
if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}

// Fetch user info
$stmt = $pdo->prepare("SELECT name, email, role, created_at FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Profiili – RuokaTalo</title>
<link rel="stylesheet" href="./css/styles.css">
</head>
<body>

<header>
    <div class="logo">Ruoka<span>Talo</span></div>

    <nav>
        <a href="index.php">Etusivu</a>
        <a href="menu.php">Ruokalista</a>
        <a href="cart.php">Ostoskori</a>
        <a href="profile.php" class="active">Profiili</a>
        <a href="logout.php">Kirjaudu ulos</a>
    </nav>
</header>

<div class="register-container">
   <h2>Profiili</h2>

    <p><strong>Käyttäjänimi:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Sähköposti:</strong> <?= htmlspecialchars($user['email']) ?></p>
    <p><strong>Osoite:</strong> <?= htmlspecialchars($user['address'] ?? 'Ei asetettu') ?></p>
    <p><strong>Liittynyt:</strong> <?= htmlspecialchars($user['created_at']) ?></p>

    <br>
     <a href="edit_profile.php" class="register-btn" style="display:block; text-align:center; margin-top:20px;">
        Muokkaa tietoja</a>
    <a href="delete_account.php" class="register-btn"   style="display:block; text-align:center; margin-top:20px; background:#d9534f;">
     Poista tili</a>
    <a href="logout.php" class="register-btn" style="text-align:center; display:block;  margin-top:20px">Kirjaudu ulos</a>

</body>
</html>
