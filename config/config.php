<?php

// データベース接続情報
define('DB_HOST', 'localhost'); // データベースホスト(接続先)名
define('DB_PORT', '3306'); // デフォルトのMySQLポート
define('DB_NAME', 'shain_kanri'); // データベース名
define('DB_USER', 'root'); // データベースユーザー名
define('DB_PASSWORD', 'root'); // データベースパスワード
// これらの定数を Database クラスが読み込み、
// PDO接続の設定に使用します。