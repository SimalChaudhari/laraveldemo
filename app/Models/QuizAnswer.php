<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class QuizAnswer extends Model
{
    use HasFactory;

    use GeneratesUuid;

    public $table = 'quiz_answers';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question_id',
        'answer'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function getAnswerAttribute($value) {
        return ( !is_null( $value ) OR !empty( $value ) ) ? json_decode( $value, true ) : [];
    }

    public function question() {
        return $this->belongsTo('App\Models\QuizQuestion');
    }

}
