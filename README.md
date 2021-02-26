# CuongDev Laravel Abstraction
#### CuongDev Laravel Abstraction for starter project
#### Bộ source code dùng làm base cho các project Laravel

```
https://github.com/cuongdev2408/larab
```

I. Bắt đầu

1. Cài đặt

- Các packages cần thiết:

```
    - prettus/l5-repository
    - tymon/jwt-auth
    - spatie/laravel-permission
```

- Package mongodb nếu cần:

```
    - jenssegers/mongodb
```

#### Lưu ý:

#### - spatie/laravel-permission đang không hoạt động với jenssegers/mongodb

#### - Sau khi cài đặt xong các package, cần làm theo hướng dẫn cài đặt của các package đó.

- Cấu hình L5-repository

`https://github.com/andersao/l5-repository#installation`

- Cấu hình JWT Auth

`https://jwt-auth.readthedocs.io/en/develop/laravel-installation/`

- Cấu hình Spatie Laravel-permission

`https://spatie.be/docs/laravel-permission/v3/installation-laravel`

- Sửa config/queues.php để có thể sử dụng DB transaction (Nếu dùng mongodb)

`https://github.com/jenssegers/laravel-mongodb#queues`

- Thêm các Provider cần thiết vào config/app.php

```
    /*
     * Package Service Providers...
     */
    CuongDev\Larab\LarabServiceProvider::class,
    Spatie\Permission\PermissionServiceProvider::class,
```

- Thêm JWT middleware vào app/Http/Kernel.php

```
  protected $routeMiddleware = [
        // Additional middleware
        'auth.jwt' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // JWT middleware
    ];
```

- Model User extends \CuongDev\Larab\App\Models\User


- Thêm biến môi trường vào file .env:

```
#Abstraction
SUPER_ADMIN_EMAIL=
SUPER_ADMIN_PASSWORD=

#Project Environment
JWT_SECRET=
JWT_PUBLIC_KEY=
JWT_PRIVATE_KEY=
JWT_PASSPHRASE=
JWT_TTL=
JWT_REFRESH_TTL=
JWT_ALGO=
JWT_LEEWAY=
JWT_BLACKLIST_ENABLED=
JWT_BLACKLIST_GRACE_PERIOD=
```
