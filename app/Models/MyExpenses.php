<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyExpenses extends Model
{
    use HasFactory;

    protected $fillable = ['expenses_category_id', 'amount', 'date'];

    public function ExpenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class);
    }
}
