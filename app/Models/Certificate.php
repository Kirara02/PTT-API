<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;
    protected $table = 'certificate_users';
    protected $fillable = ['user_id', 'certificate_path'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
