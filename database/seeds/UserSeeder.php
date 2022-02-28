<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'coolto@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'full_name' => 'Micaela Milano',
                'restaurant_name' => 'Coolto',
                'address' => 'Via Gravina, 5, 70024, Bari',
                'vat_number' => 'IT34567891234567'
            ],
            [
                'email' => 'clac@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'full_name' => 'Andrea Scarpa',
                'restaurant_name' => 'Clac',
                'address' => 'Via Altamura, 144, 70022, Giovinazzo',
                'vat_number' => 'IT12345678912345'
            ],
            [
                'email' => 'labo@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'full_name' => 'Domenico Cristo',
                'restaurant_name' => 'Labò',
                'address' => 'Via Santeramo, 16, 70100, Altamura',
                'vat_number' => 'IT45678912345678'
            ],
            [
                'email' => 'zenpub@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'full_name' => 'Tommaso Passa',
                'restaurant_name' => 'Zen Pub',
                'address' => 'Via Acquaviva, 233, 70025, Gravina in Puglia',
                'vat_number' => 'IT78912345678912'
            ],
            [
                'email' => 'londondrink@mail.com',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'full_name' => 'Marco Ferri',
                'restaurant_name' => 'London Drink',
                'address' => 'Piazza Garibaldi, 1, 70029, Santeramo',
                'vat_number' => 'IT72345678912345'
            ]
        ];

        foreach($users as $user) {
            factory(User::class)->
            create([
                'email' => $user['email'],
                'password' => $user['password'],
                'full_name' => $user['full_name'],
                'restaurant_name' => $user['restaurant_name'],
                'address' => $user['address'],
                'vat_number' => $user['vat_number']
            ])->each(function($user) {

                $category = Category::inRandomOrder()->first();

                $user -> categories() -> attach($category);

            });
        }
    }
}
