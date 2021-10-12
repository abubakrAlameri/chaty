<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileMessage extends Model
{
    use HasFactory;
     protected $fillable = [
        'msg_id',
        'path',
        'size',
    ];
    public function message()
    {
        return $this->belongsTo(Message::class , 'msg_id' , 'msg_id');
    }
}
