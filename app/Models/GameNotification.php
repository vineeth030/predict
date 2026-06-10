<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameNotification extends Model
{
    use HasFactory;

    public const TYPE_REWARD = 'REWARD';
    public const TYPE_DAILY_REWARD = 'DAILY_REWARD';
    public const TYPE_PREDICTION_REWARD = 'PREDICTION_REWARD';
    public const TYPE_SHARE_SENT = 'SHARE_SENT';
    public const TYPE_SHARE_RECEIVED = 'SHARE_RECEIVED';
    public const TYPE_REDEEM = 'REDEEM';
    public const TYPE_COUNTRY_COMPLETE = 'COUNTRY_COMPLETE';

    public $table = 'game_notification';

    public const UPDATED_AT = null;

    protected $fillable = [
        'user_id',
        'notification_type',
        'reference_id',
        'title',
        'message',
        'star_points',
        'is_read',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'reference_id' => 'integer',
        'star_points' => 'integer',
        'is_read' => 'boolean',
        'created_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
