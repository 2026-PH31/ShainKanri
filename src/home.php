<?php

session_start();

if (!isset($_SESSION['shain_id'], $_SESSION['shain_mei'])) {
    header('Location: login.php');
    exit;
}

$shainMei = $_SESSION['shain_mei'];

require __DIR__ . '/views/home_view.php';