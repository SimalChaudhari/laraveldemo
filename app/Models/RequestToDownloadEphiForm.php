<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class RequestToDownloadEphiForm extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'ehr_download_request';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'cur_date',
        'person',
        'reason',
        'description',
        'purpose',
        'necessary',
        'approve',
        'app_date',
        'not_approve',
        'buss',
        'sub',
        'agree',
        'sub_cont',
        'port',
        'device',
        'encry',
        'encry_veri',
        'records',
        'officer',
        'sign_date',
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
