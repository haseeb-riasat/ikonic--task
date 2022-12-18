<?php

namespace Database\Seeders;

use App\Models\FriendUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConnectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        FriendUser::factory()->count(50)->create();
    }
}
