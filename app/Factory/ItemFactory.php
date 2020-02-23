<?php

namespace App\Factory;

use App\Item;

/**
 * Class ItemFactory
 * @package App\Factory
 */
class ItemFactory
{
    /**
     * @param string $field
     * @return Item
     */
    public static function create(
        string $field
    ): Item {
        return Item::create([
            'field' => $field,
        ]);
    }
}
