<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Symfony\Component\Console\Question\Question;
use Illuminate\Foundation\Auth\User;

class Answer extends Model
{
    public function question() 
    {
        return $this->belongsTo('App\Question', 'question_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function getBodyHtmlAttribute()
    {
        return \Parsedown::instance()->text($this->body);
    }

    public function getCreatedDateAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public static function boot()
    {
        parent::boot();

        static::created(function($answer) {
            $answer->question->increment('answers_count');
            $answer->question->save();
        });

    }
}
