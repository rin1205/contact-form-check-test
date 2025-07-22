# お問い合わせフォーム

## 環境構築
### Dockerビルド
1. git clone https://github.com/rin1205/contact-form-check-test.git  
   cd contact-form-check-test
3. docker-compose up -d —build

### Laravel環境構築
1. docker-compose exec php bash
2. comopser install
3. cp .env.example .env
4. php artisan key:generate
5. php artisan migrate --seed

## 使用技術
Laravel 8.83.29
PHP 7.4.9
MariaDB 10.3.39（MySQL互換）
Docker
Composer 2.8.9
Laravel Fortify 

## ER図

<img width="481" height="421" alt="contact-form-check-test drawio" src="https://github.com/user-attachments/assets/bf02bda1-58e6-42f6-84b2-7e1c8f7f0060" />

## URL
開発環境 http://localhost/
phpMyAdmin http://localhost:8080/

