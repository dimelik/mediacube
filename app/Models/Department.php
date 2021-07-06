<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'title',
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'employee_department');
    }

    //this should be a repository :(
    public function getMaxPrice() {
        return $this->employees()->get()->max('salary');
    }
}
