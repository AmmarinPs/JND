<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
class Url extends Model
{
    use HasFactory;

    protected $fillable = [
        'url_original',
        'user_id',
        'url_short',
        'title',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
