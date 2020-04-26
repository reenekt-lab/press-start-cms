<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListAdditionalProperty extends Model
{
    public function set_additional_property()
    {
        return $this->hasMany(SetAdditionalProperty::class,'property_id');
    }
}
