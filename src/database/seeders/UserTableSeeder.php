<?php

namespace Database\Seeders;

use App\Models\User;
use CuongDev\Larab\Abstraction\Definition\Constant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $email = env('SUPER_ADMIN_EMAIL', 'cuongnv.developer@gmail.com');
        $password = env('SUPER_ADMIN_PASSWORD', '12345678');

        /** @var User $user */
        $user = User::where('email', $email)->first();
        if (!$user) {
            User::create([
                'name'              => 'Nguyễn Vinh Cường',
                'email'             => $email,
                'email_verified_at' => now(),
                'password'          => Hash::make($password),
                'remember_token'    => Str::random(10),
                'phone'             => '+84353437303',
                'address'           => 'Hà Nội',
                'gender'            => Constant::MALE,
                'status'            => Constant::ACTIVE,
            ]);
        }

        User::factory(10)->create();
    }
}
