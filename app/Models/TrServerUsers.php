<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrServerUsers extends Model
{
    protected $table = 'tr_server_users';
    protected $fillable = ['server_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id');
    }
}
