<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Author extends Authenticatable
{
    use HasFactory;
    public function rLanguage()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }
}

