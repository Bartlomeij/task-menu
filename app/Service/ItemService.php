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
     * @param array|null $children
     * @param Item|null $parent
     * @return Item
     */
    public function createItem(
        string $field,
        ?array $children = [],
        ?Item $parent = null
    ): Item
    {
        $item = ItemFactory::create($field);
        if ($parent) {
            $item->parent()->save($parent);
        }
        $item->save();
        if (!empty($children)) {
            foreach ($children as $child) {
                $children = $child['children'] ?? null;
                $menuItem = $this->createItem($child['field'], $children, $item);
                $item->children()->save($menuItem);
            }
        }
        return $item;
    }
}
