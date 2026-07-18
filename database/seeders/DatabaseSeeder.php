<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::create([
            'name' => 'Store Admin',
            'email' => 'admin@aishoestore.test',
            'password' => Hash::make('Admin@123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Demo customer
        User::create([
            'name' => 'Demo Customer',
            'email' => 'customer@aishoestore.test',
            'password' => Hash::make('Customer@123'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);

        $categories = [
            ['name' => 'Running Shoes', 'icon' => 'bi-lightning'],
            ['name' => 'Casual Sneakers', 'icon' => 'bi-emoji-smile'],
            ['name' => 'Sports Shoes', 'icon' => 'bi-trophy'],
            ['name' => 'Gym & Training', 'icon' => 'bi-activity'],
            ['name' => 'Walking Shoes', 'icon' => 'bi-person-walking'],
        ];

        foreach ($categories as $cat) {
            Category::create(['name' => $cat['name'], 'slug' => Str::slug($cat['name']), 'icon' => $cat['icon']]);
        }

        $shoes = [
            ['name' => 'AeroSprint Runner', 'brand' => 'Nike', 'gender' => 'male', 'activity_type' => 'running', 'price' => 95, 'cat' => 'Running Shoes'],
            ['name' => 'CloudFlex Trainer', 'brand' => 'Adidas', 'gender' => 'female', 'activity_type' => 'running', 'price' => 110, 'cat' => 'Running Shoes'],
            ['name' => 'Urban Walker Classic', 'brand' => 'Puma', 'gender' => 'unisex', 'activity_type' => 'casual', 'price' => 60, 'cat' => 'Casual Sneakers'],
            ['name' => 'StreetStyle Low-Top', 'brand' => 'Converse', 'gender' => 'unisex', 'activity_type' => 'casual', 'price' => 45, 'cat' => 'Casual Sneakers'],
            ['name' => 'ProCourt Sport', 'brand' => 'Nike', 'gender' => 'male', 'activity_type' => 'sports', 'price' => 130, 'cat' => 'Sports Shoes'],
            ['name' => 'MatchPoint Elite', 'brand' => 'Adidas', 'gender' => 'female', 'activity_type' => 'sports', 'price' => 145, 'cat' => 'Sports Shoes'],
            ['name' => 'IronCore Trainer', 'brand' => 'Reebok', 'gender' => 'male', 'activity_type' => 'gym', 'price' => 85, 'cat' => 'Gym & Training'],
            ['name' => 'FlexFit Gym Pro', 'brand' => 'Under Armour', 'gender' => 'female', 'activity_type' => 'gym', 'price' => 99, 'cat' => 'Gym & Training'],
            ['name' => 'ComfortStride Walker', 'brand' => 'Skechers', 'gender' => 'unisex', 'activity_type' => 'walking', 'price' => 55, 'cat' => 'Walking Shoes'],
            ['name' => 'EasyPace Daily', 'brand' => 'New Balance', 'gender' => 'senior', 'activity_type' => 'walking', 'price' => 65, 'cat' => 'Walking Shoes'],
            ['name' => 'Budget Runner X1', 'brand' => 'Bata', 'gender' => 'unisex', 'activity_type' => 'running', 'price' => 35, 'cat' => 'Running Shoes'],
            ['name' => 'Premium Sprint Pro', 'brand' => 'Nike', 'gender' => 'male', 'activity_type' => 'running', 'price' => 220, 'cat' => 'Running Shoes'],
        ];

        foreach ($shoes as $i => $s) {
            $category = Category::where('name', $s['cat'])->first();
            $gender = in_array($s['gender'], ['male', 'female', 'unisex']) ? $s['gender'] : 'unisex';

            Product::create([
                'category_id' => $category?->id,
                'name' => $s['name'],
                'slug' => Str::slug($s['name']).'-'.($i + 1),
                'brand' => $s['brand'],
                'gender' => $gender,
                'activity_type' => $s['activity_type'],
                'size_range' => '38-45',
                'price' => $s['price'],
                'stock' => rand(10, 80),
                'description' => "The {$s['name']} by {$s['brand']} delivers comfort and performance for {$s['activity_type']} activities.",
                'is_featured' => $i < 4,
            ]);
        }
    }
}
