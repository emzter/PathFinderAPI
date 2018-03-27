<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Job extends Model {
    protected $table = 'job_lists';
    protected $fillable = [
        'name',
        'responsibilities',
        'qualification',
        'benefit',
        'capacity',
        'cap_type',
        'disability_req',
        'salary',
        'salary_type',
        'negetiable',
        'location',
        'type',
        'level',
        'exp_req',
        'edu_req',
        'category_id',
        'company_id',
        'created_at',
        'updated_at',
        'viewer',
    ];

    public function category() {
        return $this->belongsTo('App\Models\Category', 'category_id', 'id');
    }
}