<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Societé extends Model
{
    use HasFactory;
    protected $fillable = ['name'];


    public function users()
    {
        return $this->belongsToMany(User::class, 'societé_user', 'societé_id', 'user_id');
    }
}
