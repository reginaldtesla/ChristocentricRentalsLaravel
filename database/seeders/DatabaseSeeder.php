<?php

namespace Database\Seeders;

use App\Support\AdminAccount;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        AdminAccount::sync();

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
        ]);
    }
}
