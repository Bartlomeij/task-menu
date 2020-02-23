<?php

namespace App\Service;

use App\Exceptions\EntityNotFoundException;
use App\Factory\MenuFactory;
use App\Menu;

/**
 * Class MenuService
 */
class MenuService
{
    /**
     * @param string $field
     * @param int $maxDepth
     * @param int $maxChildren
     * @return Menu
     */
    public function createMenu(
        string $field,
        int $maxDepth,
        int $maxChildren
    ): Menu
    {
        $menu = MenuFactory::create($field, $maxDepth, $maxChildren);
        $menu->save();
        return $menu;
    }

    /**
     * @param int $menuId
     * @return Menu|null
     * @throws EntityNotFoundException
     */
    public function getMenuById(int $menuId): ?Menu
    {
        $menu = Menu::find($menuId);
        if (!$menu) {
            throw new EntityNotFoundException();
        }
        return $menu;
    }

    /**
     * @param int $menuId
     * @param string $field
     * @param int $maxDepth
     * @param int $maxChildren
     * @return Menu
     * @throws EntityNotFoundException
     */
    public function updateMenu(
        int $menuId,
        ?string $field,
        ?int $maxDepth,
        ?int $maxChildren
    ): Menu
    {
        $menu = $this->getMenuById($menuId);

        // Probably is more proper way to do that in Laravel :)
        $field ? $menu->update(['field' => $field]) : null;
        $maxDepth ? $menu->update(['max_depth' => $maxDepth]) : null;
        $maxChildren ? $menu->update(['max_children' => $maxChildren]) : null;

        $menu->update();
        return $menu;
    }

    /**
     * @param int $menuId
     */
    public function deleteMenuById(int $menuId): void
    {
        $menu = Menu::find($menuId);
        if ($menu) {
            $menu->delete();
        }
    }
}
