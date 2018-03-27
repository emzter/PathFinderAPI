<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Message extends Model {
    protected $table = 'message';
    protected $fillable = [
        'title',
        'text',
        'sender',
        'reciever',
        'type',
        'readed',
        'status',
        'job_id',
        'reply_to',
    ];
}