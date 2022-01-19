<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Dyrynda\Database\Casts\EfficientUuid;
use Dyrynda\Database\Support\GeneratesUuid;

use Ramsey\Uuid\Codec\OrderedTimeCodec;
use Ramsey\Uuid\UuidFactory;

class Quiz extends Model
{
    use GeneratesUuid;

    public $table = 'quizes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'per_page_questions',
        'show_definition',
        'show_impact'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'uuid' => EfficientUuid::class,
    ];

    public function questions() {
        return $this->hasMany('App\Models\QuizQuestion')->orderByRaw('ifnull(question_order, created_at)+0 asc');
    }
}