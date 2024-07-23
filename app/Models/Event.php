<?php

namespace App\Models;

use App\Models\Category;
use App\Models\SubmissionEvent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Event extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class);
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function submissionEvent()
    {
        return $this->hasOne(SubmissionEvent::class);
    }

    public function documentation()
    {
        return $this->hasOne(Documentation::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
