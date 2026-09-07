<?php
/**
 * ログインページ
 * 社員がログインするためのプログラム
 */

session_start();

// ログイン済みの場合はホームページにリダイレクト
if (isset($_SESSION['shain_id'])) {
    header('Location: home.php');
    exit;
}

require __DIR__ . '/db.php';
require_once __DIR__ . '/../model/ShainModel.php';

$error = '';
$mailAddress = '';
// postリクエストが送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 入力値の取得 ※trim関数で前後の空白を削除
    // null合体演算子で未入力の場合は空文字を代入
    $mailAddress = trim($_POST['mail_address'] ?? '');
    $password = $_POST['password'] ?? '';

    // 入力値のバリデーション(エラーチェック)
    if ($mailAddress === '' || $password === '') {
        $error = 'メールアドレスとパスワードを入力してください';
    } else {
        // データベースから社員情報を取得
        $shain = (new ShainModel($pdo))->findByMailAddress($mailAddress);

        /*
         * 社員情報が存在し、かつパスワードが一致する場合はログイン成功
         * password_verify関数は、ハッシュ化されたパスワードと平文のパスワードを比較するための関数です。
         * 例：入力されたパスワードが「password123」で、
         * データベースに保存されているハッシュ化されたパスワードが「$2y$10$E9Q1...」の場合、
         * password_verify('password123', '$2y$10$E9Q1...')はtrueを返します。
         */
        if ($shain && password_verify($password, $shain['password'])) {
            /*
             * セッションIDを再生成してセッション固定攻撃を防ぐ
             * session_regenerate_id(true)は、現在のセッションIDを破棄し、新しいセッションIDを生成する関数です。
             * これにより、攻撃者が以前のセッションIDを使用して不正アクセスすることを防ぎます。
             */
            session_regenerate_id(true);
            $_SESSION['shain_id'] = $shain['shain_id'];
            $_SESSION['shain_mei'] = $shain['shain_mei'];
            // ログイン成功後はホームページにリダイレクト
            header('Location: home.php');
            // exitは、スクリプトの実行を終了するための関数です。
            // リダイレクト後に不要な処理が実行されないようにするために使用します。
            exit;
        }

        $error = 'メールアドレスまたはパスワードが違います';
    }
}
// ビュー(画面)の読み込み
require __DIR__ . '/views/login_view.php';