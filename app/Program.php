<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class Program extends Model
{
    protected $table = "programs";

    public function courses()
    {
        return $this->hasMany('App\Course', 'program_id', 'id');
    }

    public function steps()
    {
        return $this->hasMany('App\ProgramStep', 'program_id', 'id')->orderBy('sort_index')->orderBy('id');
    }

    public function chapters()
    {
        return $this->hasMany('App\ProgramChapter', 'program_id', 'id')->with('lessons', 'lessons.steps', 'lessons.steps.tasks', 'lessons.prerequisites')->orderBy('sort_index')->orderBy('id');
    }

    public function lessons()
    {
        return $this->hasMany('App\Lesson', 'program_id', 'id')->with('steps', 'steps.tasks', 'prerequisites')->orderBy('sort_index')->orderBy('id');
    }

    public function authors()
    {
        return $this->belongsToMany('App\User', 'programs_authors', 'program_id', 'user_id');
    }

    public static function textbooks()
    {
        return self::where('available_as_textbook', true)->get();
    }
}
