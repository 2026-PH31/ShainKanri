<?php
// modelはモデルのことで、データベース操作をまとめたディレクトリ
/**
 * 社員モデル
 * 社員情報をデータベースから取得するためのクラス
 */
class ShainModel
{
    // コンストラクタ（データベース接続用のPDOオブジェクトを受け取る）
    // コンストラクタとは、クラスのインスタンスが生成されるときに自動的に呼び出される特殊なメソッドです。
    public function __construct(private PDO $pdo)
    {
        // 初期化みたいなものが必要ならここに書く
    }

    /**
     * メールアドレスで社員情報を取得するメソッド
     * @param string $mailAddress メールアドレス
     * @return array|false 社員情報の連想配列またはfalse（見つからなかった場合）
     */
    public function findByMailAddress(string $mailAddress): array|false
    {
        // SQL文を準備して実行
        $statement = $this->pdo->prepare(
            // SQLのSELECT文を使用して、shainテーブルからshain_id、shain_mei、mail_address、passwordの列を取得する
            'SELECT shain_id, shain_mei, mail_address, password FROM shain WHERE mail_address = ?'
        );
        // SQL文のプレースホルダーに値をバインドして実行
        $statement->execute([$mailAddress]);
        // 結果を連想配列として取得して返す
        // fetch()メソッドは、結果セットから1行を取得するためのPDOStatementのメソッドです。
        // 結果が存在しない場合はfalseを返します。
        return $statement->fetch();
    }

    /**
     * 社員情報を新規登録するメソッド
     * @param string $shainMei 社員名
     * @param string $mailAddress メールアドレス
     * @param string $password パスワード（平文）
     */
    public function create(string $shainMei, string $mailAddress, string $password): void
    {
        $statement = $this->pdo->prepare(
            // SQLのINSERT文を使用して、shainテーブルに新しい社員情報を挿入する
            'INSERT INTO shain (shain_mei, mail_address, password) VALUES (?, ?, ?)'
        );
        // 暗号化はここで行う。
        // パスワードは平文のままではなく、password_hash関数を使用してハッシュ化して保存する
        $statement->execute([
            $shainMei,
            $mailAddress,
            password_hash($password, PASSWORD_DEFAULT),
        ]);
    }
}