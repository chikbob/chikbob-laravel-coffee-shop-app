<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Создаем тестового пользователя
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
        ]);

        // Создаем категории
        $categories = [
            [
                'name' => 'Эспрессо',
                'slug' => 'espresso',
                'description' => 'Классические эспрессо напитки'
            ],
            [
                'name' => 'Фильтр кофе',
                'slug' => 'filter-coffee',
                'description' => 'Кофе, приготовленный методом фильтрации'
            ],
            [
                'name' => 'Десерты',
                'slug' => 'desserts',
                'description' => 'Сладкие угощения к кофе'
            ],
            [
                'name' => 'Чай',
                'slug' => 'tea',
                'description' => 'Различные сорта чая'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Создаем продукты
        $products = [
            [
                'name' => 'Эспрессо',
                'slug' => 'espresso',
                'description' => 'Классический эспрессо 30мл',
                'price' => 120.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Американо',
                'slug' => 'americano',
                'description' => 'Эспрессо с горячей водой 200мл',
                'price' => 150.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Капучино',
                'slug' => 'cappuccino',
                'description' => 'Эспрессо с молочной пенкой 200мл',
                'price' => 180.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Латте',
                'slug' => 'latte',
                'description' => 'Эспрессо с большим количеством молока 300мл',
                'price' => 200.00,
                'category_id' => 1,
            ],
            [
                'name' => 'Фильтр кофе',
                'slug' => 'filter-coffee',
                'description' => 'Свежезаваренный фильтр кофе 300мл',
                'price' => 160.00,
                'category_id' => 2,
            ],
            [
                'name' => 'Тирамису',
                'slug' => 'tiramisu',
                'description' => 'Классический итальянский десерт',
                'price' => 250.00,
                'category_id' => 3,
            ],
            [
                'name' => 'Чизкейк',
                'slug' => 'cheesecake',
                'description' => 'Нежный чизкейк Нью-Йорк',
                'price' => 220.00,
                'category_id' => 3,
            ],
            [
                'name' => 'Зеленый чай',
                'slug' => 'green-tea',
                'description' => 'Ароматный зеленый чай 300мл',
                'price' => 100.00,
                'category_id' => 4,
            ],
            [
                'name' => 'Черный чай',
                'slug' => 'black-tea',
                'description' => 'Крепкий черный чай 300мл',
                'price' => 100.00,
                'category_id' => 4,
            ],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }
    }
}
