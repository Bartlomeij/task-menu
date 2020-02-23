<?php

namespace App\Service;

use App\Exceptions\EntityNotFoundException;
use App\Factory\MenuFactory;
use App\Item;
use App\Menu;

/**
 * Class MenuService
 */
class MenuService
{
    /**
     * @var ItemService
     */
    private $itemService;

    /**
     * MenuService constructor.
     * @param ItemService $itemService
     */
    public function __construct(ItemService $itemService)
    {
        $this->itemService = $itemService;
    }

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

    /**
     * @param int $menuId
     * @param array $items
     * @return array
     * @throws EntityNotFoundException
     */
    public function createMenuItems(int $menuId, array $items): array
    {
        $menu = $this->getMenuById($menuId);
        $itemsArray = [];
        foreach ($items as $item) {
            $menuItem = $this->itemService->createItem($item['field']);
            $menu->items()->save($menuItem);
            $itemsArray[] = $menuItem;
        }
        return $itemsArray;
    }

    /**
     * @param int $menuId
     * @return array
     * @throws EntityNotFoundException
     */
    public function getMenuItems(int $menuId): array
    {
        $menu = $this->getMenuById($menuId);
        $itemsArray = [];

        foreach ($menu->items()->get()->all() as $item) {
            $itemsArray[] = $item;
        }
        return $itemsArray;
    }

    /**
     * @param int $menuId
     * @throws EntityNotFoundException
     */
    public function deleteMenuItems(int $menuId): void
    {
        /** @var Menu $menu */
        $menu = Menu::find($menuId);
        if ($menu) {
            $menu->items()->delete();
        }
    }
}
