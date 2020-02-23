<?php

namespace Tests\Feature\Menu;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ShowMenuItemsTest
 * @package Tests\Feature
 */
class ShowMenuItemsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testShowMenuItems()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $menu->items()->save($this->createNewItem('justAtest'));
        $menu->items()->save($this->createNewItem('justAtest2'));

        $response = $this->json('GET', '/api/menus/' . $menu->getId() . '/items');
        $this->assertEquals('[{"field":"justAtest"},{"field":"justAtest2"}]', $response->getContent());
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShowNotExistingMenuItems()
    {
        $response = $this->json('GET', '/api/menus/100/items');

        $content = json_decode($response->getContent());
        $this->assertEquals('Menu with id #100 does not exist.', $content->errors);
        $response->assertStatus(404);
    }
}
