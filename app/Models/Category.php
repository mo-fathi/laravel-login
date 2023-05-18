<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;


    protected $fillable = [
        'title',
        'description'
    ];


    public function posts(): HasMany
    {
        return $this->hasMany(Post::class,'category_id');
    }

    public function user():BelongsTo
    {
        return $this->belongsTo(User::class,'owner_id');
    }
}
