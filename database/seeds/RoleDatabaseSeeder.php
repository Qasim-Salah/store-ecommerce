<?php

use Illuminate\Database\Seeder;
use \App\Models\Admin as AdminModel;

class RoleDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Role::create([
            "id" => 1,
            "name" => 'supervisor',
            "permissions" => '["products", "tags", "categories", "brands", "options", "users","setting","attributes","sliders"]',
        ]);
        \App\Models\Role::create([
            "id" => 2,
            "name" => 'admin',
            "permissions" => '["products", "tags", "categories",  "options", "users"]',
        ]);
    }
}
