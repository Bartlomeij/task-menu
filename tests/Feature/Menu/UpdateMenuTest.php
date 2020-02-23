<?php

namespace Tests\Feature\Menu;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class UpdateMenuTest
 * @package Tests\Feature
 */
class UpdateMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testUpdateMenuWithPutMethod()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PUT', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 4,
        ]);

        $this->assertEquals('value', $response->json('field'));
        $this->assertEquals(5, $response->json('max_depth'));
        $this->assertEquals(4, $response->json('max_children'));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testCannotUpdateMenuWithPutMethodWithoutField()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PUT', '/api/menus/' . $menu->getId(), [
            'max_depth' => 5,
            'max_children' => 4,
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals('"field" is required', $content->errors->field[0]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testCannotUpdateMenuWithPutMethodWithoutMaxDepth()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PUT', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
            'max_children' => 4,
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals('"max_depth" is required', $content->errors->max_depth[0]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testCannotUpdateMenuWithPutMethodWithoutMaxChildren()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PUT', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
            'max_depth' => 4,
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals('"max_children" is required', $content->errors->max_children[0]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testUpdateMenuWithPatchMethod()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PATCH', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
        ]);

        $this->assertEquals('value', $response->json('field'));
        $this->assertEquals(6, $response->json('max_depth'));
        $this->assertEquals(7, $response->json('max_children'));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdateMenuWithPatchMethod2()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PATCH', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
            'max_depth' => 5,
        ]);

        $this->assertEquals('value', $response->json('field'));
        $this->assertEquals(5, $response->json('max_depth'));
        $this->assertEquals(7, $response->json('max_children'));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdateMenuWithPatchMethod3()
    {
        $menu = $this->createNewMenu('testField', 6, 7);
        $response = $this->json('PATCH', '/api/menus/' . $menu->getId(), [
            'field' => 'value',
            'max_children' => 5,
        ]);

        $this->assertEquals('value', $response->json('field'));
        $this->assertEquals(6, $response->json('max_depth'));
        $this->assertEquals(5, $response->json('max_children'));
        $response->assertStatus(200);
    }

    /**
     * @return void
     */
    public function testUpdateNotExistingMenuWithPutMethod()
    {
        $response = $this->json('PUT', '/api/menus/100', [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 4,
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals('Menu with id #100 does not exist.', $content->errors);
        $response->assertStatus(404);
    }

    /**
     * @return void
     */
    public function testUpdateNotExistingMenuWithPatchMethod()
    {
        $response = $this->json('PATCH', '/api/menus/100', [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 4,
        ]);

        $content = json_decode($response->getContent());
        $this->assertEquals('Menu with id #100 does not exist.', $content->errors);
        $response->assertStatus(404);
    }
}
