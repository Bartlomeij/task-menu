<?php

namespace App\Service;

use App\Factory\ItemFactory;
use App\Item;

/**
 * Class ItemService
 */
class ItemService
{
    /**
     * @param string $field
     * @return Item
     */
    public function createItem(
        string $field
    ): Item
    {
        $item = ItemFactory::create($field);
        $item->save();
        return $item;
    }
}
