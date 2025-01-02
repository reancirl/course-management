<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name', 
        'description', 
        'course_category_id', 
        'gdrive_link', 
        'is_free', 
        'price'
    ];

    // Define the relationship
    public function category()
    {
        return $this->belongsTo(CoursesCategory::class, 'course_category_id');
    }

    public function payments()
    {
        return $this->belongsToMany(Payment::class, 'course_payments');
    }
}
