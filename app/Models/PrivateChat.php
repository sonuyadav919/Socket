<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrivateChat extends Model
{
    protected $guarded = [];

    public function sender()
    {
      return $this->belongsTo('App\User', 'sender_id', 'id');
    }

    public function recever()
    {
      return $this->belongsTo('App\User', 'recever_id', 'id');
    }
}
