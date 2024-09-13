<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $guarded = ['id'];

    public static function rules()
    {
        return [
            'name' => 'required|max:64'
        ];
    }

    public static function attributes()
    {
        return [
            'name' => 'Name'
        ];
    }
}
