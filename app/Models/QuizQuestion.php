<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class QuizQuestion extends Model
{
    use HasFactory;
    use GeneratesUuid;

    public $table = 'quiz_questions';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'quiz_id',
        'title',
        'definition',
        'impact',
        'options',
        'right_answers',
        'todolist'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function getOptionsAttribute($value) {
        return ( !is_null( $value ) OR !empty( $value ) ) ? json_decode( $value, true ) : [];
    }

    public function getRightAnswersAttribute($value) {
        return ( !is_null( $value ) OR !empty( $value ) ) ? json_decode( $value, true ) : [];
    }

    public function quiz() {
        return $this->belongsTo('App\Models\Quiz', 'quiz_id');
    }
}
