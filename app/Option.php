<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
  public function answers()
  {
      return $this->hasMany('App\Answer');
  }
}
