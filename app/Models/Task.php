<?php

namespace App\Models;

use App\Models\User;
use App\Models\Project;
use App\Models\WorkSession;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Task extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function workSession(): HasOne
    {
        return $this->hasOne(WorkSession::class);
    }
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
    protected $guarded = [];
}
