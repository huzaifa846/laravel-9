<?php

use App\Http\Controllers\EmailController;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use Tests\TestCase;

class EmailListTest extends TestCase
{
    public function testListReturnsJsonResponse()
    {
        $emailController = new EmailController();

        $response = $emailController->list();

        $this->assertEquals(200, $response->getStatusCode());

        $this->assertJson($response->getContent());
    }
}
