<?php

namespace Tests\Feature;

use App\Http\Services\NationalityService;
use App\Models\Nationality;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class NationalityTest extends TestCase
{
    use DatabaseMigrations;

    protected NationalityService $nationalityService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->nationalityService = $this->app->make(NationalityService::class);
    }

    public function test_get_nationality_id_by_existing_nationality_name_success(): void
    {
        $nationality = Nationality::factory()->create();
        $nationalityId = $this->nationalityService->getNationalityIdByNationalityName($nationality->name);
        $this->assertEquals($nationality->id, $nationalityId);
    }

    public function test_get_nationality_id_by_new_nationality_name_success(): void
    {
        $this->nationalityService->getNationalityIdByNationalityName('USA');
        $this->assertDatabaseHas('nationalities', [
            'id' => 1,
            'name' => 'USA',
        ]);
    }
}
