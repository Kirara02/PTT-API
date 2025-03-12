<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public static function rules($id = false)
    {
        if ($id) {
            return [
                'name' => 'required|max:128',
                'email' => 'required|email|max:128|unique:companies,email,' . $id,
            ];
        } else {
            return [
                'name' => 'required|max:128',
                'email' => 'required|email|max:128|unique:companies,email',
            ];
        }
    }
    public static function attributes()
    {
        return [
            'name' => 'Name',
            'email' => 'Email'
        ];
    }
    public function tr_users()
    {
        return $this->hasMany(TrCompanyUsers::class);
    }
    public function timezone()
    {
        return $this->belongsTo(Timezone::class, 'timezone_id');
    }
}
