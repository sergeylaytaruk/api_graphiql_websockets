<?php

// App\\Models\\Quest

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quests extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'description', 							  'reward'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
}
