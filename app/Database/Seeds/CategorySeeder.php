<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $datas = [
           array('category_name' => 'acategory 1','category_description' => 'description'),
           array('category_name' => 'bcategory 2','category_description' => 'description'),
           array('category_name' => 'ccategory 3','category_description' => 'description'),
           array('category_name' => 'dcategory 4','category_description' => 'description'),
           array('category_name' => 'ecategory 5','category_description' => 'description')
        ];

        foreach($datas as $c_data){

            // Simple Queries
            $this->db->query('INSERT INTO ilance_categories (category_name, category_description) VALUES(:category_name:, :category_description:)', $c_data);

        }       
    }
}
