<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Allowance extends Model
{
    //
    use HasFactory;

    protected $guarded = [];

    public function paidAllowances()
    {
        return $this->hasMany(PaidAllowance::class);
    }
}
