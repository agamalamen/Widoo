<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    public function users()
    {
      return $this->hasMany('App\User');
    }

    public function contributions()
    {
      return $this->hasMany('App\Contribution');
    }
}
