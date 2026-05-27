<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}

$stmt = $pdo->prepare("SELECT name, email, address FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Muokkaa profiilia – RuokaTalo</title>
<link rel="stylesheet" href="./css/styles.css">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

</head>
<body>

<header>

    <div class="logo">
        Ruoka<span>Talo</span>
    </div>

    <nav>

        <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) === 'index.php' ? 'active' : '' ?>">Etusivu</a>
        <a href="menu.php" class="<?= basename($_SERVER['PHP_SELF']) === 'menu.php' ? 'active' : '' ?>">Ruokalista</a>
        <a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cart.php' ? 'active' : '' ?>">Ostoskori <span id="cart-count"><?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?></span>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="profile.php" class="<?= basename($_SERVER['PHP_SELF']) === 'profile.php' ? 'active' : '' ?>">Profiili</a>
            <a href="logout.php" class="<?= basename($_SERVER['PHP_SELF']) === 'logout.php' ? 'active' : '' ?>">Kirjaudu ulos</a>

        <?php } else { ?>

            <a href="log_in.php" class="<?= basename($_SERVER['PHP_SELF']) === 'log_in.php' ? 'active' : '' ?>">Kirjaudu</a>
            <a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : '' ?>">Rekisteröidy</a>

        <?php } ?>

    </nav>

</header>

<div class="register-container">
    <h2>Muokkaa tietoja</h2>

    <?php if(isset($_SESSION['error'])): ?>
        <div class="msg error"><?= $_SESSION['error']; ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

   

    <form action="edit_profile_process.php" method="POST">

        <div class="input-group">
            <label>Käyttäjänimi</label>
            <input type="text" name="username" value="<?= htmlspecialchars($user['name']) ?>" required>
        </div>

        <div class="input-group">
            <label>Sähköposti</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        </div>
        <div class="input-group">
             <label>Osoite</label>
             <input type="text" name="address" value="<?= htmlspecialchars($user['address']) ?>">
        </div>

        <div class="input-group">
            <label>Uusi salasana (valinnainen)</label>
            <input type="password" name="new_password">
        </div>

        <div class="input-group">
            <label>Vahvista uusi salasana</label>
            <input type="password" name="confirm_password">
        </div>

        <button type="submit" class="register-btn">Tallenna muutokset</button>

    </form>
</div>

</body>
</html>
