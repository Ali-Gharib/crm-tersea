<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Invitation extends Model
{
    use HasFactory;
    protected $fillable = ['societé_id', 'email', 'confirmed', 'token',  'validated_at'];
    public function societe()
    {
        return $this->belongsTo(Societé::class);
    }

    public static function generateToken()
    {
          return hash_hmac('sha256', Str::random(40), config('app.key'));
    }
    public function validateInvitation()
    {
        $this->update(['validated_at' => now()]);
    }
}
