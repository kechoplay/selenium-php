<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ImageComic extends Model
{
    //
    protected $table = 'image_comic';
    public $timestamps = true;
    protected $guarded = [];

    public function comic()
    {
        return $this->belongsTo('App\Comic', 'comic_id', 'id');
    }

    public function chapter()
    {
        return $this->belongsTo('App\Chapter', 'chapter_id', 'id');
    }
}
