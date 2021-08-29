<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'article_text' , 'avatar' , 'category_id' , 'user_id'];
    
    public function tag()
    {
        return $this->belongsToMany(Tag::class , 'article_tag' );
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
