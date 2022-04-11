<?php

namespace Tests\Feature;

use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class SimpleTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        Route::get('test-throw', function () {
            throw new Exception('testing', 422);
        })->middleware('api')->prefix('api');
    }

    public function test_access_route()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_correct_json_structure_for_fail_requests()
    {
        $res = $this->getJson('/api/test-throw');
        $res->assertStatus(422)
            ->assertJsonStructure([
                'status',
                'message',
                'data',
                'code'
            ])
            ->assertJson([
                'message' => 'testing'
            ]);
    }
}
