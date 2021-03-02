<?php
use App\Models\Category as CategoryModel;
use Illuminate\Database\Seeder;

class SubCategoryDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

        public function run()
    {
        factory(CategoryModel::class,10)->create([
            'parent_id'=>$this->getRandomParentId()
        ]);
    }

        private function getRandomParentId()
    {
        return  CategoryModel::inRandomOrder()->first();
    }

}
