<?php

namespace App\Models\TaskManagement;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskMember extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function _by()
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
