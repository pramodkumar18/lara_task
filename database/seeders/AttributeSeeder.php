<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Attribute;

class AttributeSeeder extends Seeder
{
    public function run()
    {
        Attribute::create(['name' => 'Size', 'type' => 'select']);
        Attribute::create(['name' => 'Color', 'type' => 'select']);

        $sizes = ['L', 'M', 'S'];
        foreach ($sizes as $size) {
            $attribute = Attribute::where('name', 'Size')->first();
            $attribute->values()->create(['value' => $size]);

        $colors = ['Red', 'Blue', 'Green'];
        foreach ($colors as $color) {
            $attribute = Attribute::where('name', 'Color')->first();
            $attribute->values()->create(['value' => $color]);
    }
}