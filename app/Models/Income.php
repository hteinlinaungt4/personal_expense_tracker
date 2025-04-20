<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{

    protected $fillable=['user_id','category_id','amount','description'];


    public function category(){
        return $this->belongsTo(Category::class);
    }
}
