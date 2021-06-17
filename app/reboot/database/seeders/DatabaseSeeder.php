<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

	public function fromCsv(){
		\DB::table('app_role')->insert(fileCsvToArray('database/data/role.csv'));
		\DB::table('app_user')->insert(fileCsvToArray('database/data/user.csv'));
		\DB::table('app_menu')->insert(fileCsvToArray('database/data/menu.csv'));
		\DB::table('app_route')->insert(fileCsvToArray('database/data/route.csv'));
		\DB::table('app_access')->insert(fileCsvToArray('database/data/access.csv'));
	}

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->fromCsv();
        //DB::table('app_route')->insert(fileCsvToArray('database/data/route.csv'));

         //$this->call('CsvSeeder');
    }
}
