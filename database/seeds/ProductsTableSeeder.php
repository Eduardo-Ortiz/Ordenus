<?php

use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $supplies_categories = array(
            array(
                'id' => 1,
                'name' => 'Panes',
                'description' => 'Todo lo relacionado con panes.',
                'fullname' => 'Panes',
                'icon_id' => 62,
                'parent_id' => null
            ),
            array(
                'id' => 2,
                'name' => 'Proteinas',
                'description' => 'Todo tipo de carnes.',
                'fullname' => 'Proteinas',
                'icon_id' => 55,
                'parent_id' => null
            ),
            array(
                'id' => 3,
                'name' => 'Res',
                'description' => 'Todas las carnes de res.',
                'fullname' => 'Proteinas/Res',
                'icon_id' => 121,
                'parent_id' => 2
            ),
            array(
                'id' => 4,
                'name' => 'Lacteos',
                'description' => 'Todos los productos derivados de la leche.',
                'fullname' => 'Lacteos',
                'icon_id' => 74,
                'parent_id' => null
            ),
        );

        DB::table('supplies_categories')->insert($supplies_categories);

        $supplies = array(
            array(
                'id' => 1,
                'name' => 'Pan hamburgesa con ajonjoli',
                'stock' => 0,
                'unit_id' => 5,
                'supplies_category_id' => 1,
                'ingredient' => 1
            ),
            array(
                'id' => 2,
                'name' => 'Carne de res molida',
                'stock' => 0,
                'unit_id' => 1,
                'supplies_category_id' => 3,
                'ingredient' => 1
            ),
            array(
                'id' => 3,
                'name' => 'Queso amarillo',
                'stock' => 0,
                'unit_id' => 5,
                'supplies_category_id' => 4,
                'ingredient' => 1
            ),
        );

        DB::table('supplies')->insert($supplies);

        $menu_categories = array(
            array(
                'id' => 1,
                'name' => 'Comida Rapida',
                'description' => 'Variedad de "Fast Food" (Comida rapida) incluyendo hamburgesas, hot-dogs, papas fritas, etc.',
                'fullname' => 'Comida Rapida',
                'schedule_id' => null,
                'parent_id' => null
            )
        );

        DB::table('menu_categories')->insert($menu_categories);

        $products = array(
            array(
                'id' => 1,
                'name' => 'Hamburguesa con Queso',
                'description' => 'Hamburgesa con 150gr de carne de res y queso.',
                'recipe' => 1,
                'enabled' => 1,
                'price' => 55.0,
                'time' => 10,
                'menu_category_id' => 1,
                'schedule_id' => null,
                'supply_id' => null
            )
        );

        DB::table('products')->insert($products);

        $products_supplys = array(
            array(
                'product_id' => 1,
                'supply_id' => 1,
                'extra' => 0,
                'removable' => 0,
                'quantity' => 1,
                'unit_id' => 5,
                'extra_price' => null,
                'extra_quantity' => null,
                'extra_unit' => null
            ),
            array(
                'product_id' => 1,
                'supply_id' => 2,
                'extra' => 0,
                'removable' => 0,
                'quantity' => 150,
                'unit_id' => 2,
                'extra_price' => null,
                'extra_quantity' => null,
                'extra_unit' => null
            ),
            array(
                'product_id' => 1,
                'supply_id' => 3,
                'extra' => 1,
                'removable' => 1,
                'quantity' => 1,
                'unit_id' => 5,
                'extra_price' => 10.00,
                'extra_quantity' => 1.00,
                'extra_unit' => 5
            )
        );

        DB::table('product_supply')->insert($products_supplys);
    }
}
