<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmailJob;
use App\Utilities\Contracts\ElasticsearchHelperInterface;
use App\Utilities\Contracts\RedisHelperInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'emails' => 'required|array',
            'emails.*.email' => 'required|email',
            'emails.*.subject' => 'required',
            'emails.*.body' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $emails = $request->input('emails');

        foreach ($emails as $emailData) {
            $email = $emailData['email'];
            $subject = $emailData['subject'];
            $body = $emailData['body'];

            dispatch(new SendEmailJob($emailData));

            /** @var ElasticsearchHelperInterface $elasticsearchHelper */
            $elasticsearchHelper = app()->make(ElasticsearchHelperInterface::class);

            $id = $elasticsearchHelper->storeEmail($body, $subject, $email);

            /** @var RedisHelperInterface $redisHelper */
            $redisHelper = app()->make(RedisHelperInterface::class);

            // Cache information about the email in Redis
            $redisHelper->storeRecentMessage($id, $subject, $email);
        }

        return response()->json(['success' => true]);
    }

    public function list()
    {
        /** @var ElasticsearchHelperInterface $elasticsearchHelper */
        $elasticsearchHelper = app()->make(ElasticsearchHelperInterface::class);

        $emails = $elasticsearchHelper->getAllEmails();

        return response()->json($emails);
    }

}
