<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $expenseCategoryNames = [
            ['name'=>'Food & Drinks','icon_name'=>'food_and_drink'],
            ['name'=>'Shopping','icon_name'=>'shopping'],
            ['name'=>'Housing','icon_name'=>'housing'],
            ['name'=>'Travel','icon_name'=>'travel'],
            ['name'=>'Vehicles','icon_name'=>'vehicles'],
            ['name'=>'Life & Entertainment','icon_name'=>'life_and_entertainment'],
            ['name'=>'IT Devices','icon_name'=>'it_devices'],
            ['name'=>'Health','icon_name'=>'health'],
            ['name'=>'Donation','icon_name'=>'donation'],
            ['name'=>'Other','icon_name'=>'other']
        ];
        $incomeCategoryNames = [
            ['name'=>'Allowance','icon_name'=>'allowance'],
            ['name'=>'Salary','icon_name'=>'salary'],
            ['name'=>'Bonus','icon_name'=>'bonus'],
            ['name'=>'Other','icon_name'=>'other']
        ];

        foreach ($expenseCategoryNames as $categoryName){
            Category::create([
                'name'=>$categoryName['name'],
                'icon_name'=>$categoryName['icon_name'],
                'unique_id'=>'cat_expense'.Str::slug($categoryName['name']),
                'version'=>0,
                'is_default'=>true,
                'transaction_type'=>2,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
        foreach ($incomeCategoryNames as $categoryName){
            Category::create([
                'name'=>$categoryName['name'],
                'icon_name'=>$categoryName['icon_name'],
                'unique_id'=>'cat_income_'.Str::slug($categoryName['name']),
                'version'=>0,
                'is_default'=>true,
                'transaction_type'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
