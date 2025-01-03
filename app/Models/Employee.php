<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function gender()
    {
        return $this->belongsTo(Gender::class);
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function paidSalaries()
    {
        return $this->hasMany(PaidSalary::class);
    }

    public function paidAllowances()
    {
        return $this->hasMany(PaidAllowance::class);
    }
}
