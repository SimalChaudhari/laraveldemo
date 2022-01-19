<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class Result extends Model
{
    use GeneratesUuid;

    public $table = 'results';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'sess_id',
        'test_id',
        'completed',
        'datetime',
        'company_name',
        'firstname',
        'rand',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function answers() {
        return $this->hasMany('App\Models\QuizAnswer');
    }
}
