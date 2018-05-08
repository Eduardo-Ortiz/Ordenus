<?php

use Illuminate\Database\Seeder;

class UnitsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $units = array(
            array(
                'id' => 1,
                'name' => 'Kilogramos',
                'abreviation' => 'kg'
            ),
            array(
                'id' => 2,
                'name' => 'Gramos',
                'abreviation' => 'gr'
            ),
            array(
                'id' => 3,
                'name' => 'Litros',
                'abreviation' => 'l'
            ),
            array(
                'id' => 4,
                'name' => 'Mililitros',
                'abreviation' => 'ml'
            ),
            array(
                'id' => 5,
                'name' => 'Piezas',
                'abreviation' => 'pz'
            ),
        );

        DB::table('units')->insert($units);

        $equivalences = array(
            array(
                'id' => 1,
                'from_id' => 1,
                'to_id' =>2,
                'ratio' => 1000
            ),
            array(
                'id' => 2,
                'from_id' => 2,
                'to_id' =>1,
                'ratio' => 0.001
            ),
            array(
                'id' => 3,
                'from_id' => 3,
                'to_id' =>4,
                'ratio' => 1000
            ),
            array(
                'id' => 4,
                'from_id' => 4,
                'to_id' => 3,
                'ratio' => 0.001
            ),
        );

        DB::table('equivalences')->insert($equivalences);
    }
}
