<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'cost', 'description', 'expense_type'];

    protected $casts = [
        'date' => 'date:Y-m-d',
        'cost' => 'decimal:2',
    ];
}
