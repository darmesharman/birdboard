<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $attributes)
 */
class Project extends Model
{
    use HasFactory;

    public function path(): string
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class)->oldest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function addTask($body): Task
    {
        return $this->tasks()->create(compact('body'));
    }

    public function recordActivity($description): void
    {
        $this->activity()->create(compact('description'));
    }
}
