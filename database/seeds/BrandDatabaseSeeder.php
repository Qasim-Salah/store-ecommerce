<?php

use App\Models\Brand as BrandModel;
use App\Models\Category as CategoryModel;
use Illuminate\Database\Seeder;

class BrandDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(BrandModel::class, 20)->create();
    }
}
