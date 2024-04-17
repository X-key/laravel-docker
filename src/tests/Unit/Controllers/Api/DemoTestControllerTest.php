<?php

namespace Tests\Unit\Controllers\Api;

use App\Http\Controllers\Api\DemoTestController;
use App\Http\Requests\DemoTestRequest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\JsonResponse;
use Tests\TestCase;

class DemoTestControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_stores_demo_test_inquiry_successfully()
    {
        $this->withoutJobs();

        $requestData = [
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
        ];

        $request = DemoTestRequest::create('/api/demo-test', 'POST', $requestData);

        $controller = new DemoTestController();
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertJson($response->getContent());

        $responseData = json_decode($response->getContent(), true);
        $this->assertEquals('Inquiry created successfully', $responseData['message']);
    }
}
