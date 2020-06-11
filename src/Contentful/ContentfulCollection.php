<?php

namespace App\Contentful;

use Contentful\Delivery\Client;
use Contentful\Delivery\Query;

class ContentfulCollection
{
    public $client;

    public function __construct()
    {
        $this->client = new Client(
            env('CONTENTFUL_ACCESS_TOKEN'),
            env('CONTENTFUL_SPACE_ID')
        );
    }

    public function getPosts()
    {
        $query = (new Query)->setContentType('recipe')
            ->orderBy('fields.title', $descending = true);

        return collect($this->client->getEntries($query)->getItems())
            ->map(function ($item) {
                return [
                    'title' => $item->title,
                    'content' => $item->body,
                ];
            });
    }
}
