<?php

namespace CuongDev\Larab\Database\Seeders;

use App\Models\User;
use CuongDev\Larab\Abstraction\Definition\Constant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = env('SUPER_ADMIN_EMAIL', 'admin@gmail.com');
        $password = env('SUPER_ADMIN_PASSWORD', '123456');

        /** @var User $user */
        $user = User::where('email', $email)->first();
        if (!$user) {
            User::create([
                'name'              => 'Admin',
                'email'             => $email,
                'email_verified_at' => now(),
                'username'          => $email,
                'password'          => Hash::make($password),
                'remember_token'    => Str::random(10),
                'phone'             => '+84987654321',
                'address'           => 'Hà Nội',
                'gender'            => Constant::MALE,
                'status'            => Constant::ACTIVE,
            ]);
        }
    }
}
