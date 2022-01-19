<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class MediaDestructionForm extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'media_destruction_and_reuse_form';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'org',
        'device',
        'media',
        'loca',
        'item_desc',
        'model',
        'serial',
        'asset',
        'backup',
        'backup_loc',
        'descri',
        'con_date',
        'cond',
        'vali',
        'vali_phone',
        'sani',
        'notes',
        'prof',
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
