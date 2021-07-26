<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PivotArticleAndArticleTag extends Model
{
    protected $guarded = [];

    /**
     * article
     * @return HasOne
     */
    final public function Article(): HasOne
    {
        return $this->hasOne(Article::class, 'id', 'article_id');
    }

    /**
     * article tag
     * @return HasOne
     */
    final public function ArticleTag(): HasOne
    {
        return $this->hasOne(ArticleTag::class, 'id', 'article_tag_id');
    }
}
