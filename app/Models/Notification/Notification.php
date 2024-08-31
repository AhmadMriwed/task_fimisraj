<?php

namespace App\Models\Notification;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    const DIRCTORY_NOTIFICATION='Media/Notification';

    protected $fillable = [
        'title',
        'sub_title',
        'image',
        'read_at',
        'user_id',
        'body',
        'url',
       'notification_type'

    ];

    public function user()
    {
      return $this->belongsTo(User::class,'user_id');
    }
}
