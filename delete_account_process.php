<?php
session_start();
include("includes/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: log_in.php");
    exit;
}

$user_id = $_SESSION['user_id'];


$stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
$stmt->execute([$user_id]);


session_unset();
session_destroy();

header("Location: index.php");
exit;
?>
