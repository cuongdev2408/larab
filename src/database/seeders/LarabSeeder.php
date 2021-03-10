<?php

namespace Database\Seeders;

use CuongDev\Larab\Abstraction\Definition\StatusCode;
use CuongDev\Larab\App\Models\SystemOption;
use Illuminate\Database\Seeder;

class LarabSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Just run only once after init project and migrate first time
        $checkRun = SystemOption::where('meta_key', 'init_administrator_and_acl_seeder')->first();
        if (!$checkRun || $checkRun->meta_value != StatusCode::SUCCESS) {
            $this->call([
                AdministratorSeeder::class,
                AclSeeder::class,
            ]);

            SystemOption::updateOrCreate(
                ['meta_key' => 'init_administrator_and_acl_seeder'],
                ['meta_value' => StatusCode::SUCCESS]
            );
        }
    }
}
