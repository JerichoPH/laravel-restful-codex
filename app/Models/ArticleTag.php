<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleTag extends Model
{
    protected $guarded = [];

    /**
     * articles
     * @return BelongsToMany
     */
    final public function Articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'pivot_article_and_article_tags', 'article_tag_id', 'article_id');
    }
}
