<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\DemoTestRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Tests\TestCase;

class DemoTestRequestTest extends TestCase
{
    /** @test */
    public function it_passes_validation_with_valid_data()
    {
        $this->mockDatabaseForValidation();

        $request = new DemoTestRequest();
        $validator = Validator::make([
            'objects' => [
                [
                    'ref' => 'T-1',
                    'name' => 'test',
                    'description' => null
                ],
                [
                    'ref' => 'T-2',
                    'name' => 'test',
                    'description' => 'Test description'
                ]
            ],
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_fails_validation_when_object_is_inactive_in_database()
    {
        $this->mockDatabaseForValidation(true);

        $request = new DemoTestRequest();
        $validator = Validator::make([
            'objects' => [
                [
                    'ref' => 'T-1',
                    'name' => 'test',
                    'description' => null
                ],
                [
                    'ref' => 'T-2',
                    'name' => 'test',
                    'description' => 'Test description'
                ]
            ],
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('objects.0', $validator->errors()->toArray());
    }

    /**
     * Mock DB
     *
     * @param bool $includeInactive
     * @return void
     */
    protected function mockDatabaseForValidation(bool $includeInactive = false): void
    {
        DB::shouldReceive('table->where->where->exists')->andReturn($includeInactive);
    }
}
