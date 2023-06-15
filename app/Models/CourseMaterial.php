<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseMaterial extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'full_path',
    ];


    public function getFullPathAttribute()
    {
        $src = $this->getAttribute('path');
        if (is_null($src)) {
            return null;
        }
        if (!empty($this->path)) {
            return asset('storage/' . $this->path);
        }
        return null;
    }
}
