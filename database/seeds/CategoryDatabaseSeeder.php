<?php

use App\Models\Category as CategoryModel;
use Illuminate\Database\Seeder;

class CategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(CategoryModel::class, 20)->create();
    }
}
