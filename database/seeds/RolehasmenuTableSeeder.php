<?php

use Illuminate\Database\Seeder;

class RolehasmenuTableSeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        app('db')->table('std_rolehasmenu')->insert([
                [
                'id' => 1,
                'role_id' => 1,
                'menu_id' => 1
            ],
                [
                'id' => 2,
                'role_id' => 1,
                'menu_id' => 2
            ],
                [
                'id' => 3,
                'role_id' => 1,
                'menu_id' => 3
            ],
                [
                'id' => 4,
                'role_id' => 1,
                'menu_id' => 4
            ],
                [
                'id' => 5,
                'role_id' => 1,
                'menu_id' => 5
            ],
                [
                'id' => 6,
                'role_id' => 1,
                'menu_id' => 6
            ],
                [
                'id' => 7,
                'role_id' => 1,
                'menu_id' => 7
            ],
                [
                'id' => 8,
                'role_id' => 1,
                'menu_id' => 8
            ],
        ]);
    }

}
