## Advanced-mock-case

サービス名はRese（リーズ）

ある企業のグループ会社の飲食店予約サービス

外部の飲食店予約サービスは手数料を取られるので自社で予約サービスを持ちたい。

初年度でのユーザー数10,000人達成

## アプリケーションURL

- 開発環境：http://localhost/
- phpMyAdmin；http://localhost:8080/

## 機能一覧

会員登録、ログイン機能、予約追加/変更/削除、お気に入り追加/変更/削除

検索、並び替え、レビュー機能、バリデーション、レスポンシブデザイン

![スクリーンショット 2024-09-22 22.59.11.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/c0d15fd2-4f07-47d1-9f08-737c03342766/7ce5379e-9588-4b48-96f8-b300671f847c/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88_2024-09-22_22.59.11.png)

【ダミーデータの作成】

| ユーザー名 | メールアドレス | パスワード |
| --- | --- | --- |
| 管理者 | admin@admin.com | password |
| 店舗代表者 | owner@owner.com | password |
| 利用者 | user@user.com | password |

## 使用技術（実行環境）

- PHP 7.4.9
- Laravel 8.83.27
- MySQL 15.1

## テーブル設計

| **usersテーブル** |  |  |  |  |  |
| --- | --- | --- | --- | --- | --- |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| name | varchar(191) |  |  | ◯ |  |
| email | varchar(191) |  | ◯ | ◯ |  |
| password | varchar(191) |  |  | ◯ |  |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
| **Locationsテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| location | varchar(191) |  |  |  |  |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
| **Genresテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| genre | varchar(191) |  |  |  |  |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
| **Shopsテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| shop | varchar(191) |  |  |  |  |
| location_id | bigint unsigned |  |  | ◯ | locations(id) |
| genre_id | bigint unsigned |  |  | ◯ | genres(id) |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
| **Favoritesテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| user_id | bigint unsigned |  |  | ◯ | users(id) |
| shop_id | bigint unsigned |  |  | ◯ | shops(id) |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
|  |  |  |  |  |  |
| **Reservationsテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| user_id | bigint unsigned |  |  | ◯ | users(id) |
| shop_id | bigint unsigned |  |  | ◯ | shops(id) |
| date | date |  |  |  |  |
| time | time |  |  |  |  |
| number_of_people | integer |  |  |  |  |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |
|  |  |  |  |  |  |
| **Reviewsテーブル** |  |  |  |  |  |
| **カラム名** | **型** | **PRIMARY KEY** | **UNIQUE KEY** | **NOT NULL** | **FOREIGN KEY** |
| id | bigint unsigned | ◯ | ◯ |  |  |
| user_id | bigint unsigned |  |  | ◯ | users(id) |
| shop_id | bigint unsigned |  |  | ◯ | shops(id) |
| reservation_id | bigint unsigned |  |  | ◯ | reservations(id) |
| stars | integer |  |  |  |  |
| comment | text |  |  |  |  |
| crested_at | timestamp |  |  |  |  |
| updated_at | timestamp |  |  |  |  |

## ER図

![スクリーンショット 2024-09-22 23.34.26.png](https://prod-files-secure.s3.us-west-2.amazonaws.com/c0d15fd2-4f07-47d1-9f08-737c03342766/7ca59993-ed90-4820-af4b-9e76e40f961e/%E3%82%B9%E3%82%AF%E3%83%AA%E3%83%BC%E3%83%B3%E3%82%B7%E3%83%A7%E3%83%83%E3%83%88_2024-09-22_23.34.26.png)

## 環境構築

1. Dockerビルド

```
git clone git@github.com:kimihiro-nakano/beginner-mock-case.git
```

1.  DockerDesktopアプリを立ち上げる

```
docker-compose up -d --build
```

> MacのM1・M2チップのPCの場合、no matching manifest for linux/arm64/v8 in the manifest list entriesのメッセージが表示されビルドができないことがあります。 エラーが発生する場合は、docker-compose.ymlファイルのmysql内にplatformの項目を追加で記載してください
> 

```
mysql:
    platform: linux/x86_64(この文追加)
    image: mysql:8.0.26
    environment:
```

1. Laravel環境構築

```
docker-compose exec php bash
```

1. Composerのインストール

```
 composer install
```

1.  .env.exampleファイルから .envを作成し、環境変数を変更

```

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
~
MAIL_HOST=mailcatcher
~
MAIL_FROM_ADDRESS=ailcatcher@example.com
```

1. アプリケーションキーの作成

```
php artisan key:generate
```

1. マイグレーションの実行

```
php artisan migrate
```

1. シーディングの実行
