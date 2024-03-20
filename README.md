# Laravel Template

Template bao gồm:
- Framework: `laravel 8.x`
- PHP: `php-fpm 8`
- Cache: `redis`
- Webserver: `nginx`

Các biến môi trường bổ sung:
```dotenv
HTTP_PORT=80
HTTPS_PORT=443

DB_ROOT_PASSWORD=abc
```

## Hướng dẫn deploy

### Local

#### 1. Copy biến môi trường

Copy `.env` từ file `.env.example`

```shell
cp .env.example .env
```

#### 2. Chạy docker services

Tạo image cho `App` với tên là `laravel`.

```shell
docker build -t laravel .
```

Có thể thay đổi tên `App` trong file `docker-compose.yml`
với:

```yaml
services:
    app:
        image: [your_app_name]
```

Khởi chạy docker services.

```shell
docker-compose up
```

#### 3. Cài đặt dependencies

```shell
docker-compose exec app composer install
```

#### 4. Tạo application key & optimize

Tạo application key và tối ưu hóa framework

```shell
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan optimize
```

Mở đường dẫn [http://localhost](http://localhost) để truy cập ứng dụng

#### 5. Chạy migrate & seed

```shell
docker-compose exec app php artisan migrate --seed
```

### Môi trường Production

Phần [Chạy docker services](#2-chạy-docker-services) sửa câu lệnh thành

```shell
docker-compose -f docker-compose.yml -f docker-compose.prod.yml up -d
```

để load thêm các config từ file `docker-compose.prod.yml`

## Những lưu ý khác
### Cache

Xoá và làm mới toàn bộ cache cũ:

```shell
docker-compose exec app php artisan optimize
```

Hoặc có thể sử dụng những câu lệnh riêng cho từng trường hợp khác nhau:

#### Config Caching

Xoá và làm mới cache của cấu hình của framework:

```shell
docker-compose exec app php artisan config:cache
```

#### Routes Caching

Xoá và làm mới cache của route:

```shell
docker-compose exec app php artisan route:cache
```

**LƯU Ý**: Cập nhật thay đổi cấu hình `port`, chạy câu lệnh sau:

```shell
docker-compose restart
```
