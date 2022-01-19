<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRevisionState extends Model
{
    use HasFactory;

    public $table = 'policy_revision_state';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'upload_id',
        'comp_ofc',
        'comp_date',
        'revision_date',
        'revision',
        'revision_by',
        'created_at',
    ];
}
