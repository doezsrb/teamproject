<?php

namespace App\Models;

use App\Models\Task;
use App\Models\User;
use App\Models\Report;
use App\Models\Project;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

class Comment extends Model
{
    use HasFactory;
    //
    public function teams(): MorphToMany
    {
        return $this->morphedByMany(Team::class, 'commentable');
    }
    public function projects(): MorphToMany
    {
        return $this->morphedByMany(Project::class, 'commentable');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }
    protected $guarded = [];
}
