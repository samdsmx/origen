# Contribution Guidelines

https://www.apachefriends.org/download.html   XAMPP + PHP 7

Enable openssl extension

Enable php short open tag

git clone

composer update

chmod -R 755 bootstrap/cache
chmod -R 755 storage

## En caso de usar vagrant:

(dentro de vagrant) php artisan cache:clear

(fuera de vagrant) chmod -R 777 storage

(dentro de vagrant) composer dump-autoload
