<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Model\User::create([
        'user_level_id' => 'USRLVL01',
        '_full_name'	=> 'Kevin Siregar',
        '_email'	=> 'kevin@superstore.cms',
        '_password'	=> bcrypt('pidel123'),
        '_phone' => '080989999',
		]);
    }
}
