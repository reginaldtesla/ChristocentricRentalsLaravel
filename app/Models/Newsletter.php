<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Newsletter extends Model
{
    public const STATUS_DRAFT = 'draft';

    public const STATUS_SENT = 'sent';

    protected $fillable = [
        'subject',
        'body',
        'status',
        'recipient_count',
        'sent_at',
    ];

    protected function casts(): array
    {
        return [
            'sent_at' => 'datetime',
            'recipient_count' => 'integer',
        ];
    }

    public function isDraft(): bool
    {
        return $this->status === self::STATUS_DRAFT;
    }

    public function isSent(): bool
    {
        return $this->status === self::STATUS_SENT;
    }
}
