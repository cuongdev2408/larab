# CuongDev Laravel Abstraction
#### CuongDev Laravel Abstraction for starter project
#### Bộ source code dùng làm base cho các project Laravel

I. Bắt đầu

1. Cài đặt

- Các packages cần thiết:

    - jenssegers/mongodb
    - prettus/l5-repository
    - tymon/jwt-auth
    - spatie/laravel-permission

#### Lưu ý:
#### - spatie/laravel-permission đang không hoạt động với jenssegers/mongodb
#### - Sau khi cài đặt xong các package, cần làm theo hướng dẫn cài đặt của các package đó.

- Sửa config/queues.php để có thể sử dụng DB transaction (Nếu dùng mongodb)

`https://github.com/jenssegers/laravel-mongodb#queues`

- Thêm Provider vào config/app.php

```
    /*
     * Package Service Providers...
     */
    Spatie\Permission\PermissionServiceProvider::class,
    Jenssegers\Mongodb\MongodbQueueServiceProvider::class, // MongoDB
    
    /*
     * Abstraction Service Providers...
     */
    CuongDev\Larab\App\Providers\ARouteServiceProvider::class,
```

- Thêm JWT middleware vào app/Http/Kernel.php

```
  protected $routeMiddleware = [
        // Additional middleware
        'auth.jwt' => \Tymon\JWTAuth\Http\Middleware\Authenticate::class, // JWT middleware
    ];
```

- Model User extends \CuongDev\Larab\App\Models\User
