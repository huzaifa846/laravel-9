<?php

namespace Tests\Unit;

use App\Http\Controllers\EmailController;
use App\Jobs\SendEmailJob;
use App\Mail\CustomMail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendEmailJobTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function test_send_method_validates_and_sends_emails()
    {
        $controller = new EmailController();

        $emailsData = [
            [
                'email' => 'test@example.com',
                'subject' => 'Test Subject',
                'body' => 'Test Body',
            ],
        ];

        $request = new Request(['emails' => $emailsData]);

        $response = $controller->send($request);

        $this->assertEquals(200, $response->status());
    }

    public function test_send_method_validation_if_fails()
    {
        $controller = new EmailController();

        $invalidEmailData = [
            // Missing 'email', 'subject', and 'body'
        ];

        $request = new Request(['emails' => $invalidEmailData]);

        $response = $controller->send($request);

        $this->assertInstanceOf(\Illuminate\Http\JsonResponse::class, $response);
        $this->assertEquals(422, $response->getStatusCode());

        $responseData = json_decode($response->getContent(), true);

        $this->assertArrayHasKey('errors', $responseData);
    }
}
