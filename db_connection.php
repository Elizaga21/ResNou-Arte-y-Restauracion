<?php
$host = 'sql212.infinityfree.com';
$database = 'if0_36308586_resnou';
$username = 'if0_36308586';
$password = 'OfkAq8QGaX5Dn';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}
?>