<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create()
 * @method static first()
 * @method static where()
 */
class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
    ];

    public function author(){
        return $this->belongsTo(User::class);
    }
}
