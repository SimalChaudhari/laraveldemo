<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class EmailForAccessToHealth extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'email_form_for_access_to_health_record';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'date',
        'f_name',
        'l_name',
        'address1',
        'address2',
        'city',
        'state',
        'zip',
        'req_name',
        'app_name',
        'summary_charge',
        'explanation_charge',
        'expedited_charge',
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
