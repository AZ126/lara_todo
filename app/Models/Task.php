<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Task extends Model
{
    use HasFactory;
    use Notifiable;
    protected $fillable = ['title', 'description', 'deadline', 'is_completed', 'category', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
