<?php
$servername = "localhost";
$username = "Ravintola1";
$password = "Password";
$database = "Ravintola";
try {
  $pdo = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

 
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>