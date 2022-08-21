<?php

// app/graphql/queries/quest/QuestsQuery

namespace App\GraphQL\Queries\Quests;

use App\Models\Quests;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class QuestsQuery extends Query
{
    protected $attributes = [
        'name' => 'quests',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('Quest'));
    }

    public function resolve($root, $args)
    {
        return Quests::all();
    }
}
