<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    /**
     * Scope: whereIn by field name (accepts array or comma-separated string)
     */
    public function scopeWhereInField(Builder $query, string $field, array|string $values): Builder
    {
        $items = is_array($values) ? $values : array_map('trim', explode(',', (string) $values));
        $items = array_values(array_filter($items, static fn($v) => $v !== ''));
        return $items === [] ? $query : $query->whereIn($field, $items);
    }

    /**
     * Scope: whereNotIn by field name (accepts array or comma-separated string)
     */
    public function scopeWhereNotInField(Builder $query, string $field, array|string $values): Builder
    {
        $items = is_array($values) ? $values : array_map('trim', explode(',', (string) $values));
        $items = array_values(array_filter($items, static fn($v) => $v !== ''));
        return $items === [] ? $query : $query->whereNotIn($field, $items);
    }

    /**
     * Convenience scopes for common fields
     */
    public function scopeIdIn(Builder $query, array|string $ids): Builder
    {
        return $this->scopeWhereInField($query, 'id', $ids);
    }

    public function scopeIdNotIn(Builder $query, array|string $ids): Builder
    {
        return $this->scopeWhereNotInField($query, 'id', $ids);
    }
}
