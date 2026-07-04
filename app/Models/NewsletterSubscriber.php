<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'unsubscribe_token',
        'subscribed_at',
        'unsubscribed_at',
    ];

    protected function casts(): array
    {
        return [
            'subscribed_at' => 'datetime',
            'unsubscribed_at' => 'datetime',
        ];
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNull('unsubscribed_at');
    }

    public function isActive(): bool
    {
        return $this->unsubscribed_at === null;
    }

    public function unsubscribe(): void
    {
        $this->update(['unsubscribed_at' => now()]);
    }

    public static function subscribeEmail(string $email): self
    {
        $subscriber = self::firstOrNew(['email' => strtolower($email)]);

        if (! $subscriber->exists) {
            $subscriber->unsubscribe_token = Str::random(48);
            $subscriber->subscribed_at = now();
        } elseif ($subscriber->unsubscribed_at !== null) {
            $subscriber->unsubscribed_at = null;
            $subscriber->subscribed_at = now();
        }

        $subscriber->save();

        return $subscriber;
    }
}
