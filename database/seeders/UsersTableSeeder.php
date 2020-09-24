<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    use TruncateTable;

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->truncate('users');

        $user = User::create([
            'name' => 'Admin',
            'email' => 'admin@fleet.com',
            'password' => Hash::make(123456),
        ]);
        $user->is_admin = true;
        $user->save();
        
        if (config('app.env') === 'local') {
            User::factory(10)->create();
        }
    }
}
