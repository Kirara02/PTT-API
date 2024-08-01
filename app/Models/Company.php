<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public static function rules()
    {
        return [
            'name' => 'required|max:128'
        ];
    }
    public static function attributes()
    {
        return [
            'name' => 'Name'
        ];
    }
}
