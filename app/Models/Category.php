<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;

    // Added
    use SoftDeletes;

    // To indicate what fieldname/s is/are fillable
    protected $fillable = [
        "category_name",
        "user_id",
        "category_icon"
    ];

    // Table Name
    protected $table = 'categories';

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}
