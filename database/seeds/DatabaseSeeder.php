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
        $this->call('UsersTableSeeder');
        DB::table('categories')->insert(
            [
                ['label' => 'Longos'],
                ['label' => 'Midis'],
                ['label' => 'Curtos'],
                ['label' => 'Luxo'],
            ]
        );
        DB::table('roles')->insert(
            [
                ['role' => 'admin'],
                ['role' => 'pdv'],
                ['role' => 'seller'],
                ['role' => 'client'],
            ]
        );
        DB::table('user_roles')->insert(
            [
                ['users_id' => 1, 'roles_id' => 1],
                ['users_id' => 2, 'roles_id' => 2],
                ['users_id' => 3, 'roles_id' => 3],
                ['users_id' => 4, 'roles_id' => 4],
            ]
        );
    }
}
