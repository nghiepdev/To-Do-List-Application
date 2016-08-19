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
        factory(App\User::class, 10)->create()->each(function ($u) {
            if ($u->id === 1) {
                $u->email = 'test@gmail.com';
                $u->name  = 'Test';
                $u->save();
            }
        });
    }
}
