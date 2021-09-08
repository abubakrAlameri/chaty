<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextMessage extends Model
{
    use HasFactory;
    protected $fillable = [
        'text',
    ];
     public function message()
    {
        return $this->belongsTo(Message::class , 'msg_id');
    }
}
