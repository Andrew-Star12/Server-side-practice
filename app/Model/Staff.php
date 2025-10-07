<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    public $timestamps = false;
    protected $table = 'staff';

    protected $fillable = [
        'lastname',
        'firstname',
        'middlename',
        'gender',
        'birthdate',
        'address',
        'position',
        'department_id',
        'photo',
    ];

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function disciplines()
    {
        return $this->belongsToMany(Discipline::class, 'discipline_staff', 'staff_id', 'discipline_id');
    }
}