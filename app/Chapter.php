<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chapter extends Model
{
    //
    protected $table = 'chapters';
    public $timestamps = true;
    protected $guarded = [];

    public function comic()
    {
        return $this->belongsTo('App\Comic', 'comic_id', 'id');
    }

    public function image()
    {
        return $this->hasMany('App\ImageComic', 'chapter_id', 'id');
    }
}
