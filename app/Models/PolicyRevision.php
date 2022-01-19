<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class PolicyRevision extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'policy_revisions';

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

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function policy() {
        return $this->belongsTo(PolicyProcedure::class, 'policy_procedure_id');
    }

    public function emr() {
        return $this->belongsTo(EmrByState::class, 'emr_by_state_id');
    }
}
