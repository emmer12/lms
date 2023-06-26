<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Searchable;
use App\Traits\Filterable;


class Course extends Model
{
    use HasFactory;
    protected $guarded = [];

    use Searchable, Filterable;


    protected $appends = [
        'preview_url',
    ];


    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }


    public function getPreviewUrlAttribute()
    {
        $src = $this->getAttribute('preview');
        if (is_null($src)) {
            return null;
        }
        if (!empty($this->preview)) {
            return asset('storage/' . $this->preview);
        }
        return null;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'course_users');
    }
}
