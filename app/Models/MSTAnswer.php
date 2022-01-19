<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MSTAnswer extends Model
{
    use HasFactory;

    public $table = 'mst_useranswer';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'test_id',
        'user_id',
        'sess_id',
        'que_des',
        'question_number',
        'reason',
        'your_ans',
        'todolist',
        'datetime',
        'rand',
    ];
}
