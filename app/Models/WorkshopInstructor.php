<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Elequent\Relations\HasMany;
use Illuminate\Database\Eloquent\softDeletes;

class WorkshopInstructor extends Model
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'name',
        'occupation',
        'avatar',
    ];


    public function Workshops(): HasMany
    {
        return $this->hasMany(Workshops::class);
    }
}
