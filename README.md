# To-Do Planning
## To-Do Planning Projesi

## Kurulum

Öncelikle klasörümüzü sunucunun /application dizinine yüklüyoruz. `docker-compose build` komutunu çalıştırıyoruz.

Daha sonra `docker-compose up -d` komutu ile projemizi developer modunda ayağa kaldırıyoruz.

`docker-compose exec php-fpm bash`

Komutunu çalıştırıyor ve `composer install` ile kurulumu yapıyoruz.

Veritabanını kurmak için, `bash install-clean.sh` komutunu çalıştırıyoruz.

## Verilerin servislerden alınıp DB'ye yazılması;
`php bin/console get-tasks`
Komutunu çalıştırdığınız da sistem veritabanında tanımladığını provider bilgilerinden işleri çekerek MySql'e kaydeder.

## Cache temizleme
`docker-compose exec php-fpm bash`
`bash cacl.sh prod`
`bash cacl.sh dev`

Daha sonra sevislere, http://sunucuip:8000/ şeklinde sunucu ip'nize göre bağlanabilirsiniz.
