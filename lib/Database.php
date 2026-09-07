<?php
// データベース接続処理の共通クラス
class Database
{
    private static ?PDO $pdo = null; // PDOインスタンスを保持する静的プロパティ

    // データベース接続処理メソッド
    public static function connect(): PDO
    {
        // すでにPDOインスタンスが作成されている場合はそれを返す
        if (self::$pdo === null) {
            $dns = "mysql:host=" . DB_HOST
                . ";port=" . DB_PORT
                . ";dbname=" . DB_NAME
                . ";charset=utf8";
            self::$pdo = new PDO($dns, DB_USER, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // エラーモードを例外に設定
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // デフォルトのフェッチモードを連想配列に設定
            ]);
        }
        return self::$pdo;
    }

    // データベース接続を閉じるメソッド
    public static function disconnect(): void
    {
        self::$pdo = null; // PDOインスタンスを破棄して接続を閉じる
    }
}
