<?php
namespace Model;

use Illuminate\Database\Eloquent\Model;

class Discipline extends Model
{
    public $timestamps = false;
    protected $table = 'disciplines';

    protected $fillable = [
        'name'
    ];

    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'discipline_staff', 'discipline_id', 'staff_id');
    }
}