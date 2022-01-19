<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class EmailForHealthAmmendment extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'email_form_for_health_record_ammendment';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cur_date',
        'f_name',
        'l_name',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'pat_name',
        'last_date',
        'app_name',
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
