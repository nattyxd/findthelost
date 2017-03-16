<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LostItem extends Model
{
    /**
     * Get the user who submitted the lost item.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
