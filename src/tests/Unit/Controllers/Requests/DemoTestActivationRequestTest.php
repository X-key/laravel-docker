<?php

namespace Tests\Unit\Requests;

use App\Http\Requests\DemoTestActivationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class DemoTestActivationRequestTest extends TestCase
{
    /** @test */
    public function it_passes_validation_with_valid_data()
    {
        $request = new DemoTestActivationRequest();
        $validator = Validator::make([
            'refs' => ['ref1', 'ref2'],
        ], $request->rules());

        $this->assertFalse($validator->fails());
    }

    /** @test */
    public function it_fails_validation_with_missing_refs()
    {
        $request = new DemoTestActivationRequest();
        $validator = Validator::make([], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('refs', $validator->errors()->toArray());
    }

    /** @test */
    public function it_fails_validation_with_non_array_refs()
    {
        $request = new DemoTestActivationRequest();
        $validator = Validator::make([
            'refs' => 'not_an_array',
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('refs', $validator->errors()->toArray());
    }

    /** @test */
    public function it_fails_validation_with_invalid_refs()
    {
        $request = new DemoTestActivationRequest();
        $validator = Validator::make([
            'refs' => ['ref1', 123],
        ], $request->rules());

        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('refs.1', $validator->errors()->toArray());
    }

    /** @test */
    public function it_throws_validation_exception_on_invalid_data()
    {
        $this->expectException(ValidationException::class);

        $request = new DemoTestActivationRequest();
        $request->merge([
            'refs' => 'not_an_array',
        ]);
        $request->validate();
    }
}
