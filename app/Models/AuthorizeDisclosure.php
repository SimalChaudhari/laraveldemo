<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class AuthorizeDisclosure extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'authorize_use_and_disclosure';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name',
        'ss',
        'rec_name',
        'rec_phone',
        'rec_address',
        'rec_city',
        'rec_state',
        'rec_zip',
        'from_name',
        'from_phone',
        'from_address',
        'from_city',
        'from_state',
        'from_zip',
        'purposes',
        'authorize',
        'insert_date',
        'pat_name',
        'date',
        'pat_sign',
        'pat_legal',
        'pat_rel',
        'hiv_aids',
        'mental_health',
        'domestic',
        'genetic_test',
        'drug_alcohol',
        'signature_str_svg',
        'signature_str_base',
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
