<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Application extends Model {
    protected $table = 'application_lists';
    protected $fillable = [
        'user_id',
        'job_id',
        'message',
        'status'
    ];
}