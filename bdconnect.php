<?php
$dbhost='mysql:host=localhost;dbname=auto';
$dbuser='root';
$dbpass='';
$pdo = new PDO(
    $dbhost,
    $dbuser,
    $dbpass,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
$pdo->exec('SET NAMES utf8');
?>