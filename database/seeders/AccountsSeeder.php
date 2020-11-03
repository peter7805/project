<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Accounts::factory(10)->create();
    }
}
