<?php
$host = 'localhost';
$dbname = 'u347334547_recetas_app';
$username = 'u347334547_admin_recetas';
$password = 'CH7322a#';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die('Error de conexión: ' . $e->getMessage());
}
?>