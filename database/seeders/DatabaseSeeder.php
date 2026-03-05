<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\BusinessContacts;
use App\Models\BusinessFactories;
use App\Models\BusinessProducts;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UsersTableSeeder::class,
            NotificationMessagesTableSeeder::class,
        ]);


//
//         User::factory(10)->create();
//         Business::factory(5)->create();
//         BusinessContacts::factory(20)->create();
//         BusinessFactories::factory(20)->create();
//         BusinessProducts::factory(50)->create();
    }
}
