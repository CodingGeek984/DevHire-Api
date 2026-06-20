<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'title',
        'description',
        'budget',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
        'budget' => 'decimal:2',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }
}
