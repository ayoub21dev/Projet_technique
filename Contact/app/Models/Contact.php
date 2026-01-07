<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'telephone',
        'photo',
        'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cities()
    {
        return $this->belongsToMany(City::class);
    }
}
