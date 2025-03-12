<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServerCompany extends Model
{
    public $timestamps = false;
    protected $table = 'server_companies';

    public function server()
    {
        return $this->belongsTo(Server::class, 'server_id', 'id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
}
