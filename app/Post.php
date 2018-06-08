<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $table = 'posts';
    protected $guarded = array('id');
    protected $fillable = ['title','content'];
    public $timestamps = true;

    public function getData(){
        $data = DB::table($this->table)->get();

        return $data;
    }
}
