<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Models\User::class)->create();

        $types   = [
            'Aparelho de Pressao',
            'Balanca',
            'Bengala',
            'Estetoscopio',
            'Bomba Cirurgica',
            'Maca',
            'Balao de Oxigenio',
            'Pinca',
            'Prato Termico',
            'Oximetro',
            'Otoscopio',
            'Oftalmoscopio',
            'Vaporizador',
            'Lipoaspirador',
            'Lupa',
            'Luva',
            'Seringa'
        ];

        foreach($types as $type) {
            factory(App\Models\ProductType::class)->create(['name' => Str::snake($type)]);
        }

        $brands = ['BUNZL', 'Lifemed', 'Roma', 'Biomedical'];

        for($i = 0; $i < 46; $i ++) {
            $brandId = array_rand($brands);
            $typeId = rand(3, 16);

            factory(App\Models\Product::class)->create([
                'name'=> $types[$typeId].' '.rand(1, 1000) ,
                'product_type_id' => $typeId + 1,
                'brand' => $brands[$brandId]
            ]);
        }

        factory(App\Models\Product::class)->create(['name' => 'Balanca 1', 'product_type_id' => 2, 'brand' => 'Roma', 'stock' => 25, 'amount' => 199.90, 'created_at' => '2019-10-03 17:00:00']);
        factory(App\Models\Product::class)->create(['name' => 'Aparelho de Pressao 1', 'product_type_id' => 1, 'brand' => 'BUNZL', 'created_at' => '2019-10-03 17:00:00']);
        factory(App\Models\Product::class)->create(['name' => 'Aparelho de Pressao 1', 'product_type_id' => 1, 'brand' => 'Lifemed', 'created_at' => '2019-10-03 16:00:00']);
        factory(App\Models\Product::class)->create(['name' => 'Seringa ' . rand(1, 1000), 'product_type_id' => 17, 'stock' => 310]);
    }
}
