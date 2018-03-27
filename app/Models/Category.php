<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    protected $table = 'job_categories';
    public $timestamps = false;

    protected $fillable = [
        'parent_id',
        'name',
        'icon',
    ];

    public function jobs() {
        return $this->hasMany('App\Models\Job', 'category_id', 'id');
    }
}