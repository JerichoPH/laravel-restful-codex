<?php

namespace App\Serializers;

use jericho\LaravelRestfulCodex\Serializers\Serializer;

class ArticleSerializer extends Serializer
{
    /**
     * scheme
     * @return string[]
     */
    final public function withSearch(): array
    {
        return [
            'ArticleCategory',
            'ArticleTags' => function ($ArticleTags) {
                $ArticleTags->when($this->__options['request_data']->get('article_tag_name'), function ($query, $article_tag_name) {
                    $query->where('name', $article_tag_name);
                });
            },
        ];
    }
}
