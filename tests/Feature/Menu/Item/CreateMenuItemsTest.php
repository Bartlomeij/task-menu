<?php

namespace Tests\Feature\Menu\Item;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateMenuItemsTest
 * @package Tests\Feature
 */
class CreateMenuItemsTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCreateMenuItems()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('POST', '/api/menus/' . $menu->getId() . '/items', [
            ['field' => 'value'],
            ['field' => 'value2'],
            ['field' => 'value3'],
        ]);
        $this->assertEquals([
            ['field' => 'value'],
            ['field' => 'value2'],
            ['field' => 'value3'],
        ], $response->json());
        $response->assertStatus(201);
    }
}
