<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'isbn', 'value', 'store_id'];

    protected $hidden = ['store_id'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
