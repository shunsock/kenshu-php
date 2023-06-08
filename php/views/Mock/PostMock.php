<?php

namespace App\Mock;

use App\Model\Post;

class PostMock
{
    public static function getPost(): Post
    {
        return new Post(
            id: 1,
            title: 'title',
            user_id: 1,
            thumbnail: 'thumbnail',
            body: 'body',
            created_at: 3000,
            updated_at: 3000
        );
    }
}