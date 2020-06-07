<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comic extends Model
{
    //
    protected $table = 'comics';
    public $timestamps = true;
    protected $guarded = [];

    public function chapters()
    {
        return $this->hasMany('App\Chapter', 'comic_id', 'id');
    }

    public function image()
    {
        return $this->hasMany('App\ImageComic', 'comic_id', 'id');
    }

    public static function insertOrUpdated($data)
    {
        $isset = self::whereRaw('LOWER(`name`) LIKE ?', trim(strtolower($data['name'])))->get()->first();
        if (!$isset) {
            self::create($data);
        } else {
            self::where('id', $isset->id)->update(['total_episodes' => $data['total_episodes']]);
        }
    }
}
