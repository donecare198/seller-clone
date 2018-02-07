<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        DB::table('config')->delete();
        $data=[
        	[
        		'key'=>'logo',
        		'value'=>'Auto-Sub',
        		'link'=>'null'
        	],
        	[
        		'key'=>'logo-mini',
        		'value'=>'ATS',
        		'link'=>'null'
        	],
        	[
        		'key'=>'copyright',
        		'value'=>'Auto-Sub',
        		'link'=>'null'
        	],
        	[
        		'key'=>'powered',
        		'value'=>'Tiz',
        		'link'=>'https://www.facebook.com/boynb98'
        	],
        	[
        		'key'=>'ctk',
        		'value'=>'xxx',
        		'link'=>'null'
        	],
        	[
        		'key'=>'stk',
        		'value'=>'zzzz',
        		'link'=>'null'
        	],
        	[
        		'key'=>'nganhang',
        		'value'=>'hhhh',
        		'link'=>'null'
        	],
        	[
        		'key'=>'clone',
        		'value'=>'1000',
        		'link'=>'null'
        	],
        ];
        DB::table('config')->insert($data);
    }
}
