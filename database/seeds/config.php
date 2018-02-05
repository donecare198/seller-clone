<?php
use Illuminate\Database\Seeder;
class config extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data=[
        	[
        		'key'=>'admin@gmail.com',
        		'value'=>bcrypt('123456'),
        		'link'=>'1'
        	],
        	[
        		'email'=>'mod@gmail.com',
        		'password'=>bcrypt('123456'),
        		'level'=>'2'
        	],
        	[
        		'email'=>'vip@gmail.com',
        		'password'=>bcrypt('123456'),
        		'level'=>'3'
        	],
        ];
        DB::table('config')->insert($data);
    }
}
