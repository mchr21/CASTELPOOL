<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name'=>'LARAVEL Y LIVEWIRE',
            'cost'=>200,
            'price'=>350,
            'barcode'=>'123213545155155',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>1,
            'image'=>'curso.png'

        ]);
        Product::create([
            'name'=>'RUNNING NIKE',
            'cost'=>600,
            'price'=>1350,
            'barcode'=>'516516516516',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>2,
            'image'=>'curso.png'

        ]);
        Product::create([
            'name'=>'IPNONE',
            'cost'=>900,
            'price'=>1450,
            'barcode'=>'25151155155',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>3,
            'image'=>'curso.png'

        ]);
        Product::create([
            'name'=>'LARAVEL 10',
            'cost'=>200,
            'price'=>350,
            'barcode'=>'123213545155155',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>1,
            'image'=>'curso.png'

        ]);
        Product::create([
            'name'=>'PC GAMER',
            'cost'=>200,
            'price'=>350,
            'barcode'=>'123213545155155',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>4,
            'image'=>'curso.png'

        ]);
        Product::create([
            'name'=>'LARAVEL Y LIVEWIRE',
            'cost'=>200,
            'price'=>350,
            'barcode'=>'123213545155155',
            'stock'=>1000,
            'alerts'=>10,
            'Category_id'=>1,
            'image'=>'curso.png'

        ]);
        
    }
}
