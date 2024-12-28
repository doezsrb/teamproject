<?php

namespace App\Models;

use App\Models\Task;
use App\Models\Team;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Project extends Model
{
    use HasFactory;
    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }
    public function comments(): MorphToMany
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    protected $guarded = [];
}
