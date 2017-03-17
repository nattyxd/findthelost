<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemRequest extends Model
{
     /**
     * Get the user who submitted the request.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
