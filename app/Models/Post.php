<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = ('posts');
    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'url',
        'content',
        'user_id',
        'status',
        'image',
        'image_url'
    ];

    public function incrementReadCount()
    {
        $this->views++;
        return $this->save();
    }

    public function category()
    {
        return $this->hasMany(Category::class); //don't forget to import
    }
    public function files()
    {
        return $this->hasMany(File::class); //don't forget to import
    }
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'post_tags');
    }
}
