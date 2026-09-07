<?php

session_start();

if (isset($_SESSION['shain_id'])) {
    header('Location: home.php');
    exit;
}

require __DIR__ . '/db.php';
require_once __DIR__ . '/../model/ShainModel.php';

$error = '';
$shainMei = '';
$mailAddress = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $shainMei = trim($_POST['shain_mei'] ?? '');
    $mailAddress = trim($_POST['mail_address'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($shainMei === '' || $mailAddress === '' || $password === '') {
        $error = 'すべての項目を入力してください';
    } elseif (!filter_var($mailAddress, FILTER_VALIDATE_EMAIL)) {
        $error = 'メールアドレスの形式が正しくありません';
    } elseif ((new ShainModel($pdo))->findByMailAddress($mailAddress)) {
        $error = 'このメールアドレスは登録済みです';
    } else {
        (new ShainModel($pdo))->create($shainMei, $mailAddress, $password);
        header('Location: login.php');
        exit;
    }
}

require __DIR__ . '/views/register_view.php';