<?php

namespace Tests;

use App\Factory\MenuFactory;
use App\Menu;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * @param string $field
     * @param int $maxDepth
     * @param int $maxChildren
     * @return Menu
     */
    protected function createNewMenu(
        string $field,
        int $maxDepth,
        int $maxChildren
    ): Menu {
        $menu = MenuFactory::create($field, $maxDepth, $maxChildren);
        $menu->save();
        return $menu;
    }
}
