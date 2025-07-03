<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class categorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'title'=>'category1',
                'image'=>'',
                'description'=>'description'
            ],
            [
                'title'=>'category1',
                'image'=>'',
                'description'=>'description'
            ],
            [
                'title'=>'category2',
                'image'=>'',
                'description'=>'description'
            ],
            [
                'title'=>'category3',
                'image'=>'',
                'description'=>'description'
            ]
        ];
        foreach($data as $val){
            Category::create($val);
        }
    }
}
