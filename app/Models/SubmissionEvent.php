<?php

namespace App\Models;

use App\Models\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubmissionEvent extends Model
{
    use HasFactory;
    protected $table = 'submission_events';
    protected $guarded = ['id'];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }
}
