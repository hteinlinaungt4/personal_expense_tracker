<?php

namespace App\Models;

use App\Models\Income;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    //
    protected $fillable = [
        'name'
    ];

    public function incomes(){
        return $this->hasMany(Income::class);
    }

    public function outcomes(){
        return $this->hasMany(Outcome::class);
    }
}
