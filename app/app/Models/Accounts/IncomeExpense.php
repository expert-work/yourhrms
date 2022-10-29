<?php

namespace App\Models\Accounts;

use App\Models\User;
use App\Models\Accounts\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Activitylog\Traits\LogsActivity;

class IncomeExpense extends Model
{
    use HasFactory, SoftDeletes,LogsActivity;

    protected $fillable = [
        'category_id',
        'user_id',
        'date',
        'amount',
        'due_date',
        'paid_amount',
        'note',
        'payment_type_id',
        'status_id',
        'author_info_id'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
