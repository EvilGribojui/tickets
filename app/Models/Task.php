<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'priority', 
        'subject', 
        'sender', 
        'body', 
        'recipients', 
        'attachments', 
        'assigned_user_id', 
        'status'
    ];

    protected $casts = [
        'recipients' => 'array',
        'attachments' => 'array',
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }
}

