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
            'Food & Drinks',
            'Shopping',
            'Housing',
            'Transportation',
            'Vehicles',
            'Life & Entertainment',
            'IT Devices',
            'Health',
            'Donation'
        ];
        $incomeCategoryNames = [
            'Allowance',
            'Salary',
            'Bonus',
            'Other'
        ];

        foreach ($expenseCategoryNames as $categoryName){
            Category::create([
                'name'=>$categoryName,
                'unique_id'=>'cat_'.Str::slug($categoryName),
                'version'=>0,
                'is_default'=>true,
                'transaction_type'=>1,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
        foreach ($incomeCategoryNames as $categoryName){
            Category::create([
                'name'=>$categoryName,
                'unique_id'=>'cat_'.Str::slug($categoryName),
                'version'=>0,
                'is_default'=>true,
                'transaction_type'=>2,
                'created_at'=>now(),
                'updated_at'=>now()
            ]);
        }
    }
}
