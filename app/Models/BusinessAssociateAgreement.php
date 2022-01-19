<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class BusinessAssociateAgreement extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'business_associate_agreements';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'covered_entity',
        'business_associate',
        'agreement_dated_on',
        'effective_date',
        'covered_entity_name_footer',
        'covered_entity_signature_base',
        'coverted_entity_print_name',
        'covered_entity_title',
        'covered_entity_date',
        'business_associate_name_footer',
        'business_associate_signature_base',
        'business_associate_print_name',
        'business_associate_title',
        'business_associate_date',
        'covered_entity_signature_svg',
        'business_associate_signature_svg',
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
