<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject', 
        'sender', 
        'recipients', 
        'body', 
        'attachments', 
        'status', 
        'assigned_to', 
        'priority'
    ];

    protected $casts = [
        'recipients' => 'array',
        'attachments' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}