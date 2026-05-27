<?php
session_start();
?>

<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Ravintola</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
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
        <a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cart.php' ? 'active' : '' ?>">Ostoskori</a>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="profile.php">Profiili</a>
            <a href="logout.php">Kirjaudu ulos</a>

        <?php } else { ?>

            <a href="log_in.php" class="<?= basename($_SERVER['PHP_SELF']) === 'log_in.php' ? 'active' : '' ?>">Kirjaudu</a>
            <a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : '' ?>">Rekisteröidy</a>

        <?php } ?>

    </nav>

</header>


<!-- HERO -->

<section class="hero">

    <div class="hero-content">

        <h1>Herkullista ruokaa<br>nopeasti kotiin</h1>

        <p>
            Tilaa suosikkiateriasi helposti ja nauti tuoreesta ruoasta kotona.
        </p>

        <a href="menu.php" class="btn">
            Katso ruokalista
        </a>

    </div>

</section>




<footer>
    © 2026 Ravintolan hallintajärjestelmä
</footer>

</body>
</html>
