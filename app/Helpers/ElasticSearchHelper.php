<?php

namespace App\Helpers;

use Elasticsearch\ClientBuilder;
use App\Utilities\Contracts\ElasticsearchHelperInterface;

class ElasticsearchHelper implements ElasticsearchHelperInterface
{
    private $elasticsearchClient;

    public function __construct()
    {
        $this->elasticsearchClient = ClientBuilder::create()->build();
    }

    public function storeEmail(string $messageBody, string $messageSubject, string $toEmailAddress): mixed
    {
        $params = [
            'index' => 'emails',
            'body' => [
                'message_body' => $messageBody,
                'message_subject' => $messageSubject,
                'to_email_address' => $toEmailAddress,
                'timestamp' => time(),
            ],
        ];

        // Store the email in Elasticsearch and return the inserted record's ID
        $response = $this->elasticsearchClient->index($params);

        return $response['_id'];
    }

    public function getAllEmails(): array
    {
        $index = 'emails';

        $params = [
            'index' => $index,
            'body' => [
                'query' => [
                    'match_all' => new \stdClass(),
                ],
            ],
        ];

        $response = $this->elasticsearchClient->search($params);

        // Extract the hits from the response and return them as an array
        return array_map(function ($hit) {
            return $hit['_source'];
        }, $response['hits']['hits']);
    }
}
