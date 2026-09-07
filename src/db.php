<?php
// データベース接続処理の共通ファイル
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../lib/Database.php';

$pdo = Database::connect();