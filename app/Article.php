<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Article extends Model
{
    protected $fillable = ['title', 'body'];

    public function getById($id) {
      $article = DB::table('articles')->where('id', $id)->first();
      return $article;
    }
}
