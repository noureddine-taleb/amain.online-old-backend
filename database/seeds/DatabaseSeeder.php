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
        Schema::disableForeignKeyConstraints();

        $this->call([
            UserSeeder::class,
            BillSeeder::class,
            // AlertSeeder::class,
            ProjectSeeder::class,
            PaymentSeeder::class,
        ]);
        Schema::enableForeignKeyConstraints();
    }
}
