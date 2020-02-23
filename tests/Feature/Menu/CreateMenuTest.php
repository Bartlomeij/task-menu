<?php

namespace Tests\Feature\Menu;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class CreateMenuTest
 * @package Tests\Feature
 */
class CreateMenuTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return void
     */
    public function testCreateMenu()
    {
        $response = $this->json('POST', '/api/menus', [
            'field' => 'value',
            'max_depth' => 5,
            'max_children' => 4,
        ]);
        $this->assertEquals('value', $response->json('field'));
        $this->assertEquals(5, $response->json('max_depth'));
        $this->assertEquals(4, $response->json('max_children'));
        $response->assertStatus(201);
    }

    /**
     * @return void
     */
    public function testCannotCreateMenuWithoutField()
    {
        $response = $this->json('POST', '/api/menus', [
            'max_depth' => 5,
            'max_children' => 5,
        ]);
        $content = json_decode($response->getContent());

        $this->assertEquals('"field" is required', $content->errors->field[0]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testCannotCreateMenuWithoutMaxDepth()
    {
        $response = $this->json('POST', '/api/menus', [
            'field' => 'value',
            'max_children' => 5,
        ]);
        $content = json_decode($response->getContent());

        $this->assertEquals('"max_depth" is required', $content->errors->max_depth[0]);
        $response->assertStatus(422);
    }

    /**
     * @return void
     */
    public function testCannotCreateMenuWithoutMaxChildren()
    {
        $response = $this->json('POST', '/api/menus', [
            'field' => 'value',
            'max_depth' => 5,
        ]);
        $content = json_decode($response->getContent());

        $this->assertEquals('"max_children" is required', $content->errors->max_children[0]);
        $response->assertStatus(422);
    }
}
