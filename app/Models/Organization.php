<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class, 'organization_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'organization_id');
    // }


    public function events()
    {
        return $this->hasMany(Event::class);
    }
}
