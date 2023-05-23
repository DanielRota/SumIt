<?php

try {
    $pdo = new PDO("mysql:host=" . 'localhost' . ";dbname=" . 'my_danielrota', 'root', 'QYWa429dZCk3');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("ERROR: Could not connect. " . $e->getMessage());
}
