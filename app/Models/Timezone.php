<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Timezone extends Model
{
    protected $table = 'timezones';
    protected $guarded = ['id'];

    public function companies()
    {
        return $this->hasMany(Company::class);
    }
}
