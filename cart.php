<?php
session_start();

include("includes/db.php");





$products = [];
$total = 0;

if (!empty($_SESSION['cart'])) {
    $ids = implode(",", array_keys($_SESSION['cart']));
    $stmt = $pdo->query("SELECT * FROM products WHERE id IN ($ids)");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($products as $p) {
        $total += $_SESSION['cart'][$p['id']]['price']
        * $_SESSION['cart'][$p['id']]['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="fi">
<head>
<meta charset="UTF-8">
<title>Ostoskori</title>
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
        <a href="cart.php" class="<?= basename($_SERVER['PHP_SELF']) === 'cart.php' ? 'active' : '' ?>">Ostoskori <span id="cart-count"><?= isset($_SESSION['cart']) ? array_sum(array_column($_SESSION['cart'], 'quantity')) : 0 ?></span>

        <?php if(isset($_SESSION['user_id'])){ ?>

            <a href="profile.php">Profiili</a>
            <a href="logout.php">Kirjaudu ulos</a>

        <?php } else { ?>

            <a href="log_in.php" class="<?= basename($_SERVER['PHP_SELF']) === 'log_in.php' ? 'active' : '' ?>">Kirjaudu</a>
            <a href="register.php" class="<?= basename($_SERVER['PHP_SELF']) === 'register.php' ? 'active' : '' ?>">Rekisteröidy</a>

        <?php } ?>

    </nav>

</header>


<div class="cart-area">

        <h2>Tuotteet korissa</h2>

        <?php if (empty($products)): ?>
            <p>Ostoskorisi on tyhjä.</p>
        <?php else: ?>

        <?php foreach ($products as $p): ?>
            <div class="cart-item" data-id="<?= $p['id'] ?>" data-price="<?= $p['price'] ?>">
        
                <div class="cart-info">
                    <h3><?= $p['name'] ?></h3>
                    <p class="price">Yksikköhinta: <?= number_format($p['price'], 2) ?> €</p>

                    

                    <p class="line-price">
                        <?= number_format($_SESSION['cart'][$p['id']]['price'] * $_SESSION['cart'][$p['id']]['quantity'], 2) ?> €
                    </p>

                </div>
            </div>
        <?php endforeach; ?>

        <div class="checkout-box">
            <h3>Yhteensä: <span class="total-price"><?= number_format($total, 2) ?> €</span></h3>
            <a href="checkout.php" class="checkout-btn">Tee tilaus</a>
        </div>

        <?php endif; ?>

    

</div>



</body>
</html>
