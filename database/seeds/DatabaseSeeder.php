<?php

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
        // $this->call(UserSeeder::class);
         $this->call(SettingDatabaseSeeder::class);
        $this->call(  AdminDatabaseSeeder::class);
        $this->call(  CategoryDatabaseSeeder::class);
        $this->call(  BrandDatabaseSeeder::class);
        $this->call(  ProductDatabaseSeeder::class);
        $this->call(  RoleDatabaseSeeder::class);
    }
}
