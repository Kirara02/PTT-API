<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrCompanyUsers extends Model
{
    protected $table = 'tr_company_users';
    protected $fillable = ['company_id', 'user_id'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
