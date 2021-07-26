<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Article extends Model
{
    protected $guarded = [];

    /**
     * article category
     * @return HasOne
     */
    final public function ArticleCategory(): HasOne
    {
        return $this->hasOne(ArticleCategory::class, 'id', 'article_category_id');
    }

    /**
     * article tags
     * @return BelongsToMany
     */
    final public function ArticleTags(): BelongsToMany
    {
        return $this->belongsToMany(ArticleTag::class, 'pivot_article_and_article_tags', 'article_id', 'article_tag_id');
    }
}
