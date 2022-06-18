<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function document()
    {
        return $this->hasOne(Document::class, 'fk_office_owner', 'id');
    }
}
