<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public static function rules()
    {
        return [
            'user_id' => 'required',
            'latitude' => 'nullable',
            'longitude' => 'nullable',
        ];
    }
    public static function attributes()
    {
        return [
            'user_id' => 'User',
            'latitude' => 'Latitude',
            'longitude' => 'Longitube'
        ];
    }
}
