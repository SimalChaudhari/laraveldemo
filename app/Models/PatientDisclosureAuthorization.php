<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class PatientDisclosureAuthorization extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'patient_disclosure_authorization';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'patient_name',
        'section_one_data',
        'form_purpose',
        'authorization_start',
        'authorization_expiry',
        'acknowledgement_by',
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

    public function getSectionOneDataAttribute($value) {
        return ( !is_null( $value ) OR !empty( $value ) ) ? json_decode( $value, true ) : [];
    }
}
