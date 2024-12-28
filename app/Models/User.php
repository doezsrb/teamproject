<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Role;
use App\Models\Task;
use App\Models\Team;
use App\Models\Comment;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    public function isAdmin(): bool
    {
        return $this->roles()->where('name', 'Admin')->exists();
    }
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
    public function workSessions(): HasMany
    {
        return $this->hasMany(WorkSession::class);
    }


    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withPivot('team_id')->withTimestamps();
    }
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }
    public function createdTeams(): HasMany
    {
        return $this->hasMany(Team::class, 'user_id');
    }
    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class);
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
