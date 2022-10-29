<?php

namespace App\Models\Hrm;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    //Get attribute
    public function getContactForAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($key == 1) {
            return 'Support';
        } elseif ($key == 0) {
            return 'Query';
        }
        return $key;
    }
    public function getContactStatusAttribute($key)
    {
        $value = parent::getAttribute($key);
        if ($value == 0) {
            return 'Unread';
        }
        if ($value == 1) {
            return 'Read';
        }
        return $value;
    }
}
