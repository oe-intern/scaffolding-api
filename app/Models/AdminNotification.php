<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;

class AdminNotification extends DatabaseNotification
{
    /**
     * @var string
     */
    protected $table = 'admin_notifications';

    /**
     * Notifiable relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Admin user relationship
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function adminUser()
    {
        return $this->belongsTo(AdminUser::class, 'notifiable_id');
    }
}
