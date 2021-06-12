<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('app_user', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('role_id')->constrained('app_role');
            $table->string('name')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean('is_active')->default(1);

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->timestamp('deleted_at')->nullable();
        });

        DB::table('app_user')->insert([

			['role_id' => 1	, 'name' => 'drax', 'email' => 'pondrax3@gmail.com', 'password' => bcrypt('lumen123')],
			['role_id' => 2	, 'name' => 'admin', 'email' => 'administa@lumen.com', 'password' => bcrypt('lumen123')],

		]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('app_user');
    }
}
