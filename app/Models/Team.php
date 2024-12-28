<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function comments(): MorphToMany
    {
        return $this->morphToMany(Comment::class, 'commentable');
    }
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
    protected $guarded = [];
}
