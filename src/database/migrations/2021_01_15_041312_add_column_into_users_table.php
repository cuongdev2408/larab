<?php

use CuongDev\Larab\Abstraction\Definition\Constant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnIntoUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('remember_token');
            $table->text('address')->nullable()->after('phone');
            $table->tinyInteger('gender')->nullable()->default(Constant::MALE)->after('address');
            $table->tinyInteger('status')->default(Constant::ACTIVE)->after('gender');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address', 'gender', 'status']);
            $table->dropSoftDeletes();
        });
    }
}
