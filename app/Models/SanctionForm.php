<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class SanctionForm extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'sanctions_form';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'rep_date',
        'vio_date',
        'org',
        'job',
        'method',
        'descr',
        'grp1',
        'grp2',
        'grp3',
        'sanct',
        'add_info',
        'type_of',
        'field1',
        'field2',
        'breach',
        'deter',
        'involve',
        'offence',
        'train',
        'comments',
        'report'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];
}
