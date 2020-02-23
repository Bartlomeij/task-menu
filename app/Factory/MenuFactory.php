<?php

namespace App\Factory;

use App\Menu;

/**
 * Class MenuFactory
 * @package App\Factory
 */
class MenuFactory
{
    /**
     * @param string $field
     * @param int $maxDepth
     * @param int $maxChildren
     * @return Menu
     */
    public static function create(
        string $field,
        int $maxDepth,
        int $maxChildren
    ): Menu {
        return Menu::create([
            'field' => $field,
            'max_depth' => $maxDepth,
            'max_children' => $maxChildren,
        ]);
    }
}
