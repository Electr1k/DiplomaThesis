<?php

namespace Tests\Unit\Repositories;

use App\Models\Cabinet;
use App\Repositories\CabinetRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CabinetRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CabinetRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = new CabinetRepository();
    }

    /** @test */
    public function test_returns_all_cabinets_without_filters()
    {
        Cabinet::factory()->count(3)->create();

        $result = $this->repository->getAll([]);

        $this->assertCount(3, $result);
    }

    /** @test */
    public function test_filters_cabinets_by_region_name()
    {
        Cabinet::factory()->create(['region_name' => 'Москва']);
        Cabinet::factory()->create(['region_name' => 'Санкт-Петербург']);

        $result = $this->repository->getAll(['search' => 'Москва']);

        $this->assertCount(1, $result);
        $this->assertEquals('Москва', $result->first()->region_name);
    }

    /** @test */
    public function test_filters_cabinets_by_legal_name()
    {
        Cabinet::factory()->create(['legal_name' => 'Иванов А. А.']);
        Cabinet::factory()->create(['legal_name' => 'Петров Б. Б.']);

        $result = $this->repository->getAll(['search' => 'Иванов']);

        $this->assertCount(1, $result);
        $this->assertEquals('Иванов А. А.', $result->first()->legal_name);
    }

    /** @test */
    public function test_creates_new_cabinet_if_not_exists()
    {
        $data = [
            'courier_partner_id' => 1,
            'region_name' => 'Москва',
            'legal_name' => 'Иванов А. А.',
        ];

        $this->repository->store($data);

        $this->assertDatabaseHas('cabinets', $data);
    }

    /** @test */
    public function test_updates_existing_cabinet_if_courier_partner_id_exists()
    {
        $existingCabinet = Cabinet::factory()->create(['courier_partner_id' => 1, 'legal_name' => 'Старый владелец']);

        $updatedData = [
            'courier_partner_id' => 1,
            'legal_name' => 'Новый владелец',
        ];

        $cabinet = $this->repository->store($updatedData);

        $this->assertEquals('Новый владелец', $cabinet->legal_name);
        $this->assertEquals($existingCabinet->courier_partner_id, $cabinet->courier_partner_id);
    }
}
