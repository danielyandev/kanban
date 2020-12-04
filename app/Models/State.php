<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'order'
    ];

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Tasks is state
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tasks()
    {
        return $this->hasMany(Task::class)->with(['creator', 'assignedUser']);
    }
}
