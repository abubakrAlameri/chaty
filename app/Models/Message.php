<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

      protected $fillable = [
        'part_id',
        'type',
        'is_read',
    ];
    public function participant()
    {
        return $this->belongsTo(Participant::class,'part_id');
    }

    public function textMessages()
    {
        return $this->hasMany(TextMessage::class, 'msg_id','msg_id');
    }
}
