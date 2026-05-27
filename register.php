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

<div class="register-container">
    <h2>Luo tili</h2>
    <?php if(isset($_SESSION['error'])): ?>
    <div id="msg" class="msg error"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if(isset($_SESSION['success'])): ?>
    <div id="msg" class="msg success"><?= $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

    <form action="register_process.php" method="POST">

        <div class="input-group">
            <label>Käyttäjänimi</label>
            <input type="text" name="username" value="<?= $_SESSION['old_username'] ?? '' ?>" required>
        </div>

        <div class="input-group">
            <label>Sähköposti</label>
            <input type="email" name="email"  value="<?= $_SESSION['old_email'] ?? '' ?>" required>
        </div>
        <div class="input-group">
             <label>Osoite (valinnainen)</label>
             <input type="text" name="address" value="<?= $_SESSION['old_address'] ?? '' ?>">
        </div>

        <div class="input-group">
            <label>Salasana</label>
            <input type="password" name="password" required>
        </div>

        <div class="input-group">
            <label>Vahvista salasana</label>
            <input type="password" name="confirm_password" required>
        </div>

        <button type="submit" class="register-btn">Rekisteröidy</button>

        <div class="login-link">
            <p>Onko sinulla jo tili? <a href="log_in.php">Kirjaudu sisään</a></p>
        </div>

    </form>
</div>
<script>
    const inputs = document.querySelectorAll("input");
    const msg = document.getElementById("msg");

    inputs.forEach(input => {
        input.addEventListener("input", () => {
            if (msg) msg.style.display = "none";
        });
    });
</script>
<?php unset($_SESSION['old_email']); ?>
<?php unset($_SESSION['old_username']); ?>
</body>
</html>