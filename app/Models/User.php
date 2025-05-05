<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guard = "web";
    public $timestamps = true;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'balance',
        'demo_balance',
        'withdraw_balance',
        'refcode',
        'referral_code',
        'refearned',
        'password',
        'status',
        'created_at',
        'updated_at',
        'real_password'
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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    public function deposits(): HasMany
    {
        return $this->hasMany(deposits::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::created(function ($user) {
            session(['just_registered' => true]);
        });
    }

    public function scopeSearch(Builder $query, string $term): Builder
    {
        $preparedTerm = $this->prepareSearchTerm($term);

        return $query->whereRaw(
            'MATCH(username, email) AGAINST(? IN BOOLEAN MODE)',
            [$preparedTerm]
        );

    }

    protected function prepareSearchTerm(string $term): string
    {
        $words = explode(' ', trim($term));

        $preparedWords = array_map(function($word) {
            if (strlen($word) > 2 && !preg_match('/[+\-><*~"()@]/', $word)) {
                return '+' . $word . '*'; // Add '+' for required, '*' for wildcard
            }
            return $word . '*'; // Add wildcard for partial matching
        }, $words);

        return implode(' ', $preparedWords);
    }
}
