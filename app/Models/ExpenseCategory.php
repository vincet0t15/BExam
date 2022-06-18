<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function myExpenses()
    {
        $this->hasmany(myExpenses::class, 'expenses_category_id', 'id');
    }
}
