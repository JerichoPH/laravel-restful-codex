<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArticleCategory extends Model
{
    protected $guarded = [];

    /**
     * articles
     * @return HasMany
     */
    final public function Articles():HasMany
    {
        return $this->hasMany(Article::class,'article_category_id','id');
    }
}
