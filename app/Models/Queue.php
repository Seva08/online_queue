<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Queue extends Model
{
    use HasFactory; 

    protected $table = 'queues';

    protected $fillable = [
        'user_id', 'no'
    ];

    protected $hidden = [
    ];

    /**
     * Get the user associated with this queue
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
