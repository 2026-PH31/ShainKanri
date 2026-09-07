<?php
/**
 * ログアウト処理
 * 社員がログアウトするためのプログラム
 */
session_start();
$_SESSION = [];

/**
 * セッションIDを破棄することで、セッション固定攻撃を防ぐ
 * session.use_cookiesが有効な場合、セッションIDを格納しているクッキーを削除する
 * setcookie関数は、クッキーを設定するための関数です。
 * ここでは、セッションIDを格納しているクッキーを削除するために使用しています。
 * setcookie関数の第2引数に空文字を指定し、第3引数に過去の時刻を指定することで、クッキーを削除することができます。
 */
if (ini_get('session.use_cookies')) {
    $parameters = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000, $parameters['path'], $parameters['domain'],
     $parameters['secure'], $parameters['httponly']);
}
// ★セッションを破棄することで、ログアウト処理を完了する
session_destroy();
// ★ログインページにリダイレクトする
header('Location: login.php');
exit;