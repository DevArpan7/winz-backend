<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubChapter extends Model
{
    use SoftDeletes;
    protected $table = 'sub_chapters';
    function chapter()
    {
    	return $this->belongsTo('App\Models\Chapter','chapterId','id');
    }

    function category()
    {
        return $this->belongsTo('App\Models\Category','categoryId','id');
    }
    function course()
    {
        return $this->belongsTo('App\Models\Course','courseId','id');
    }

    function question()
    {
    	return $this->hasMany('App\Models\Question','subChapterId','id');
    }
}
