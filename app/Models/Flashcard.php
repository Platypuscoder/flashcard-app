<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Flashcard extends Model
{

    use HasFactory;

    protected $fillable = ['deck_id', 'question', 'answer', 'hint', 'image'];
}
