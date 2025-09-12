<?php

namespace Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $table = 'staff';
    protected $fillable = [
        'lastname', 'firstname', 'middlename', 'gender', 'birthdate',
        'address', 'position', 'department_id'
    ];

    public $timestamps = false;

    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
