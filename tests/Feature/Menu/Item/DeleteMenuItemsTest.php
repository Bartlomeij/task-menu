<?php

namespace Tests\Feature\Menu;

use App\Menu;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DeleteMenuItemsTest
 * @package Tests\Feature
 */
class DeleteMenuItemsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testDeleteMenuItems()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $menu->items()->save($this->createNewItem('justAtest'));
        $menu->items()->save($this->createNewItem('justAtest2'));
        $response = $this->json('DELETE', '/api/menus/' . $menu->getId() . '/items');
        $response->assertStatus(204);

        /** @var Menu $menu */
        $menu = Menu::find($menu->getId());
        $this->assertTrue($menu->items()->get()->isEmpty());
    }

    /**
     * @return void
     */
    public function testDeleteNotExistingOne()
    {
        $response = $this->json('DELETE', '/api/menus/100/items');
        $response->assertStatus(204);
        $menu = Menu::find(100);
        $this->assertNull($menu);
    }
}
