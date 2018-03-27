<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class PersonalDetail extends Model {
    protected $table = 'personal_details';
    public $timestamps = false;
    
    protected $fillable = [
        'first_name',
        'last_name',
        'sex',
        'birthdate',
        'telephone',
        'facebook',
        'twitter',
        'line',
        'other_link',
        'disability',
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }
}