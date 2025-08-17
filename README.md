#もぎたて
##環境構築
###Dockerビルド
1.git clone git@github.com:coachtech-material/laravel-docker-template.git
2.mv laravel-docker-template test-mogitate
3.docker-compose up -d --build

###Laravel環境構築
1.composer install
2.cp .env.example .env
3.php artisan key:generate

コントローラ
1.php artisan make:controller ProductController

マイグレーション
1.php artisan make:migration create_seasons_table
2.php artisan make:migration create_products_table
3.php artisan make:migration create_product_season_table
4.php artisan migrate

モデル
1.php artisan make:model Product
2.php artisan make:model Season

シーディング
1.php artisan make:seeder SeasonsTableSeeder
2.php artisan make:seeder ProductsTableSeeder
3.php artisan make:seeder ProductSeasonTableSeeder
4.php artisan db:seed

##使用技術
・PHP  7.4.9
・Laravel Framework 8.83.8
・Mysql 8.0.26

##ER図
![Alt text](/src/ER.png)

##URL
・開発環境：<http://localhost/>
・phpMyAdmin：<http://localhost:8080/>
