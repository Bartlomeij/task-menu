<?php

namespace Tests\Feature\Menu;

use App\Menu;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class DeleteMenuTest
 * @package Tests\Feature
 */
class DeleteMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testDeleteMenu()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('DELETE', '/api/menus/' . $menu->getId());

        $response->assertStatus(204);
        $menu = Menu::find($menu->getId());
        $this->assertNull($menu);
    }

    /**
     * @return void
     */
    public function testDeleteNotExistingOne()
    {
        $response = $this->json('DELETE', '/api/menus/100');
        $response->assertStatus(204);
        $menu = Menu::find(100);
        $this->assertNull($menu);
    }
}
