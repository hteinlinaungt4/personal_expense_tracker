<?php

namespace App\Models;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Outcome extends Model
{
    /** @use HasFactory<\Database\Factories\OutcomeFactory> */
    use HasFactory;


    protected $fillable=['user_id','category_id','amount','description'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
