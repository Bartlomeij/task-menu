<?php

namespace Tests\Feature\Menu;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class ShowMenuTest
 * @package Tests\Feature
 */
class ShowMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testShowMenu()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('GET', '/api/menus/' . $menu->getId());

        $this->assertEquals('testField', $response->json('field'));
        $this->assertEquals(6, $response->json('max_depth'));
        $this->assertEquals(7, $response->json('max_children'));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testShowNotExistingMenu()
    {
        $response = $this->json('GET', '/api/menus/100');

        $content = json_decode($response->getContent());
        $this->assertEquals('Menu with id #100 does not exist.', $content->errors);
        $response->assertStatus(404);
    }
}
