<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB:table('users')->insert([
            'name'=>'Andrey Naumoff',
	        'email'=>'admin@gmail.com',
	        'password'=>bcrypt('secret')
        ]);
        factory('App\User',17)->create()->each(function($u){
        	$u->animals()->save()
        });
    }
}
