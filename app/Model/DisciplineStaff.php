<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class DisciplineStaff extends Model
{
    public $timestamps = false;
    protected $table = 'discipline_staff';

    protected $fillable = [
        'staff_id',
        'discipline_id'
    ];
}
