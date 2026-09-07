-- ============================================================
--  社員管理システム  データベース構築スクリプト（MySQL）
--  作成者：高橋 真広 ／ 2026年度 HAL名古屋
-- ------------------------------------------------------------
--  ◆使い方（XAMPP の MySQL を想定）
--    1) コマンドで実行する場合
--         mysql -u root -p < shain_kanri.sql
--    2) phpMyAdmin の場合
--         「SQL」タブにこのファイルの中身を貼り付けて実行
--
--  ◆命名ルール … テーブル名・カラム名はローマ字で分かりやすく
--    例）社員=shain / 社員ID=shain_id / 部署=busho
-- ============================================================

-- データベースを作成（既にあれば作り直す）
DROP DATABASE IF EXISTS shain_kanri;
CREATE DATABASE shain_kanri
  DEFAULT CHARACTER SET utf8mb4
  DEFAULT COLLATE utf8mb4_general_ci;

USE shain_kanri;


-- ============================================================
--  部署マスタ（busho）… 社員が所属する部署の一覧
-- ============================================================
DROP TABLE IF EXISTS busho;
CREATE TABLE busho (
    busho_id   INT          NOT NULL AUTO_INCREMENT  COMMENT '部署ID（自動採番）',
    busho_mei  VARCHAR(50)  NOT NULL                 COMMENT '部署名',
    PRIMARY KEY (busho_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='部署マスタ';


-- ============================================================
--  社員（shain）… 社員管理システムのメインテーブル
--  ※ shain_id は AUTO_INCREMENT なので、登録時は値を入れない
-- ============================================================
DROP TABLE IF EXISTS shain;
CREATE TABLE shain (
    shain_id      INT          NOT NULL AUTO_INCREMENT  COMMENT '社員ID（自動採番・主キー）',
    shain_mei     VARCHAR(50)  NOT NULL                 COMMENT '社員名（氏名）',
    mail_address  VARCHAR(100) NOT NULL                 COMMENT 'メールアドレス',
    password      VARCHAR(255) NOT NULL                 COMMENT 'パスワード（ログイン用・後の回で使用）',
    busho_id      INT              NULL                 COMMENT '部署ID（busho.busho_id を参照）',
    yakushoku     VARCHAR(30)      NULL                 COMMENT '役職',
    nyusha_bi     DATE             NULL                 COMMENT '入社日',
    kyuyo         INT              NULL                 COMMENT '給与（月額・円）',
    PRIMARY KEY (shain_id),
    UNIQUE  KEY  uq_shain_mail (mail_address),
    CONSTRAINT fk_shain_busho FOREIGN KEY (busho_id) REFERENCES busho (busho_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='社員';


-- ============================================================
--  サンプルデータ（動作確認用）
-- ============================================================
INSERT INTO busho (busho_mei) VALUES
    ('営業部'),
    ('開発部'),
    ('総務部'),
    ('人事部');

INSERT INTO shain
    (shain_mei, mail_address, password, busho_id, yakushoku, nyusha_bi, kyuyo) VALUES
    ('山田 太郎', 'yamada@example.com',     'pass1234', 2, '主任', '2018-04-01', 320000),
    ('佐藤 花子', 'sato@example.com',       'pass1234', 1, '一般', '2020-04-01', 280000),
    ('鈴木 一郎', 'suzuki@example.com',     'pass1234', 2, '課長', '2012-04-01', 450000),
    ('田中 美咲', 'tanaka@example.com',     'pass1234', 3, '一般', '2021-10-01', 270000),
    ('高橋 健',   'takahashi@example.com',  'pass1234', 4, '部長', '2008-04-01', 600000);


-- ============================================================
--  CRUD 文の例（必要に応じて「-- 」を外して実行）
--  ※ 第13回は【登録（INSERT）】がメインテーマ
-- ============================================================

-- 【一覧参照：Read】全社員を表示
-- SELECT * FROM shain ORDER BY shain_id;

-- 【一覧参照：Read】部署名つきで表示（busho と結合）
-- SELECT s.shain_id, s.shain_mei, b.busho_mei, s.yakushoku, s.kyuyo
--   FROM shain s
--   LEFT JOIN busho b ON s.busho_id = b.busho_id
--   ORDER BY s.shain_id;

-- 【登録：Create】新しい社員を1件追加（shain_id は書かない）
-- INSERT INTO shain (shain_mei, mail_address, password, busho_id, yakushoku, nyusha_bi, kyuyo)
--   VALUES ('新人 太郎', 'shinjin@example.com', 'pass1234', 1, '一般', '2025-04-01', 250000);

-- 【変更：Update】指定した社員の給与・役職を更新
-- UPDATE shain SET kyuyo = 330000, yakushoku = '主任' WHERE shain_id = 1;

-- 【削除：Delete】指定した社員を削除
-- DELETE FROM shain WHERE shain_id = 5;
