<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class EmployeeTermination extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'emp_termi_form';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'name_practice',
        'name_employee',
        'rsn_termination',
        'termination_vol',
        'termination_force',
        'admin_access',
        'windowacc',
        'practiceacc',
        'ehracc',
        'keys_facility',
        'security_entry',
        'code_for_entry',
        'device',
        'patient_info',
        'patient_info_dlt',
        'email_pass',
        'notes',
        'form_name',
        'form_title',
        'windowacc_date',
        'practiceacc_date',
        'ehracc_date',
        'formcomplte_date',
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
