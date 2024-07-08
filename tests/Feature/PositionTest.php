<?php

namespace Tests\Feature;

use App\Http\Services\PositionService;
use App\Models\Position;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class PositionTest extends TestCase
{
    use DatabaseMigrations;

    protected PositionService $positionService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->positionService = $this->app->make(PositionService::class);
    }

    public function test_get_position_id_by_existing_position_name_success(): void
    {
        $position = Position::factory()->create();
        $positionId = $this->positionService->getPositionIdByPositionName($position->name);
        $this->assertEquals($position->id, $positionId);
    }

    public function test_get_position_id_by_new_position_name_success(): void
    {
        $this->positionService->getPositionIdByPositionName('Center');
        $this->assertDatabaseHas('positions', [
            'id' => 1,
            'name' => 'Center',
        ]);
    }

    public function test_get_positions_success(): void
    {
        Position::factory()->count(2)->create();

        $response = $this->getJson('/api/positions');
        $response->assertStatus(200)
            ->assertJson(function (AssertableJson $json) {
                $json->has('data', 2, function (AssertableJson $json) {
                    $json->whereType('name', 'string');
                })
                    ->where('message', 'Positions successfully retrieved');
            });
    }
}
