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
        // Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            ProjectSeeder::class,
            BillSeeder::class,
            PaymentSeeder::class,
        ]);
        // Schema::enableForeignKeyConstraints();
    }
}
