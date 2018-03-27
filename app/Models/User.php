<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class User extends Model {
    protected $fillable = [
        'email',
        'user_group',
        'status',
        'skip',
        'validate',
        'language',
        'profile_image',
        'header_image',
        'created_at',
        'updated_at',
    ];

    protected $hidden = [
        'password'
    ];

    public function setPasswordAttribute($pass){
        $this->attributes['password'] = Hash::make($pass);
    }

    public function details() {
        return $this->hasOne('App\Models\PersonalDetail', 'user_id', 'id');
    }
}