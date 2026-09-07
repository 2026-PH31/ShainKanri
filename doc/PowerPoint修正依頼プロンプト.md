# PowerPoint修正依頼プロンプト

次の PowerPoint 資料を修正してください。

- 対象ファイル: `PH31_第16回_課題7_ユーザー認証（DB版）.pptx`
- 目的: 課題の要件、データベース名、ファイル構成を矛盾なく統一する
- 方針: スライドのデザイン、配色、フォント、レイアウトは維持し、下記の文言と構成だけを修正する

## 修正内容

### スライド3: テーブル名と要件番号

- 「members テーブルにユーザーを登録する画面」を「shain テーブルに社員を登録する画面」に変更する。
- 要件番号が「④」の次に「⑥」となっているため、以降を連番に修正する。
  - ⑤ 認証成功時: セッションに社員IDを保存し、ホーム画面へ遷移
  - ⑥ 認証失敗時: エラーメッセージを表示
  - ⑦ ログアウト機能（セッション破棄）

### スライド4・7・11・18: MVC要件の統一

「MVCチェック（必須）」と「ログイン処理は1ファイルにまとめる」「MVCはプラスアルファ」が矛盾しているため、MVCを必須要件として統一する。

- スライド4の「SQLはModelのみに記述されていること」は維持する。
- スライド7のファイル構成を次の内容に変更する。

```text
config/config.php     … データベース接続情報
lib/Database.php      … PDO接続を生成する共通クラス
model/ShainModel.php  … shainテーブルへのSQLを記述するModel
src/login.php         … ログイン処理を受け持つController
src/register.php      … 社員登録処理を受け持つController
src/home.php          … ログイン状態を確認するController
src/logout.php        … セッションを破棄するController
src/views/            … ログイン・登録・ホーム画面のView
```

- スライド11の「1ファイルの中で」を「Controllerで受け取り・照合・遷移を行い、画面表示はViewに分離する」に変更する。
- スライド18は「プラスアルファ」という表現を削除し、今回の提出物のMVC構成として説明する内容に変更する。

### スライド5: 配置先とアクセスURL

この教材の実際の配置先に合わせ、以下のように変更する。

```text
③ ソースは C:\xampp\htdocs\PH31\20260907base に配置
④ http://localhost/PH31/20260907base/src/login.php で確認
```

### スライド6・10・12・14: テーブル名の統一

- 認証に使うテーブル名をすべて `shain` に統一する。
- 認証に使用する列は `mail_address` と `password`、ログイン後にセッションへ保存する社員情報は `shain_id` と `shain_mei` であることを明記する。
- 登録処理のSQLは以下の内容に統一する。

```sql
INSERT INTO shain (shain_mei, mail_address, password) VALUES (?, ?, ?)
```

### スライド8・9: DB接続情報の扱い

- 接続情報をソースコードに直接書かず、`config/config.php` に定義する構成へ変更する。
- `root` ユーザーのパスワードは環境によって異なるため、「XAMPPの設定に合わせて `DB_PASSWORD` を設定する」と注記する。
- 接続処理は `lib/Database.php` に集約し、各Controllerは `src/db.php` を `require` してPDOインスタンスを取得する説明に変更する。

## 確認事項

- `shain` テーブルの `shain_mei`、`mail_address`、`password` 以外の必須列に、既定値またはNULL許可が設定されていることを確認する。設定されていない場合は、登録用SQLに必要な列を追加する。
- HTML表示時のエラーメッセージ・氏名・メールアドレスには `htmlspecialchars()` を使用する説明を残す。
- 認証時はプレースホルダ、`password_verify()`、`session_regenerate_id(true)` を必須とする。