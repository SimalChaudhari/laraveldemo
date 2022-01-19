<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'company_name',
        'website',
        'emp_title',
        'address_one',
        'address_two',
        'city',
        'state',
        'zip',
        'phone',
        'monthly_fees',
        'is_terminated',
        'created_at'
    ];
}