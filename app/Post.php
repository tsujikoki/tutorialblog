<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table = 'posts';
    protected $fillable = ['title','content'];
    public $timestamps = true;
}
