<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UploadAgreement extends Model
{
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'file',
        'type',
        'size',
        'user_id',
        'company_name',
        'firstname',
    ];
}
