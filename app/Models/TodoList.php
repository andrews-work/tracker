<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TodoList extends Model {
    use HasFactory;

    protected $table = 'todoList';
    protected $fillable = [

        'name',
        'category',
        'importance',
        'date',
        'color',
        'items',
        'tag',
        'folder',
        'subFolder',
        'user_id',
    ];
}