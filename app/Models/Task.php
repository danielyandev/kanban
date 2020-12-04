<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    public static $priorities = [
        'No priority',
        'Low',
        'Medium',
        'High'
    ];

    protected $fillable = [
        'name', 'description', 'state_id', 'user_id', 'assigned_user_id', 'deadline', 'priority'
    ];

    protected $appends = ['priority_name'];

    public function getPriorityNameAttribute()
    {
        return self::$priorities[$this->priority];
    }

    /**
     * User who created the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * User who is assigned to the task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }
}
