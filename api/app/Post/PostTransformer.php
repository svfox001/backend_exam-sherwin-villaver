<?php

namespace App\Post;

class PostTransformer
{
    public function transform(array $array)
    {
        return [
            'data' => $array['data'],
            'links' => [
                'first' => $array['first_page_url'],
                'last' => $array['last_page_url'],
                'prev' => $array['prev_page_url'],
                'next' => $array['next_page_url'],
            ],
            'meta' => [
                'current_page' => $array['current_page'],
                'from' => $array['from'],
                'last_page' => $array['last_page'],
                'path' => $array['path'],
                'per_page' => $array['per_page'],
                'to' => $array['to'],
                'total' => $array['total'],
            ]
        ];
    }
}