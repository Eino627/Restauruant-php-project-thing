<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Poista tili – RuokaTalo</title>
<link rel="stylesheet" href="./css/styles.css">
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
    <h2>Haluatko varmasti poistaa tilisi?</h2>

    <p style="text-align:center; margin-bottom:20px;">
        Tämä toiminto on pysyvä. Kaikki tietosi poistetaan.
    </p>

    <form action="delete_account_process.php" method="POST">
        <button type="submit" class="register-btn" 
                style="background:#d9534f; width:100%; margin-bottom:10px;">
            Kyllä, poista tili
        </button>
    </form>

    <a href="profile.php" class="register-btn" 
       style=" display:block; text-align:center;">
       Peruuta
    </a>
</div>

</body>
</html>
