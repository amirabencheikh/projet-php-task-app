<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'start_date', 'due_date', 'description', 'user_created_by',  'user_assigned_to'];
    private $color = [
        'new' => 'bg-red-500',
        'en attente' => 'bg-yellow-500',
        'en cours' => 'bg-blue-500',
        'terminer' => 'bg-green-500'
    ];



    public function statusColor(): string
    {
        return $this->color[$this->status];
    }
    public function users()
    {
        return $this->belongsTo(User::class);
    }

    public function createdByUser()
    {
        return $this->belongsTo(User::class, 'user_created_by');
    }
    public function assignUser()
    {
        return $this->belongsTo(User::class, 'user_assign_to');
    }
    public function isActive()
    {
        $now = Carbon::now();
        $start_date = Carbon::parse($this->start_date);
        $due_date = Carbon::parse($this->due_date);
        return $now->isAfter($start_date) && $now->isBefore($due_date) && !in_array($this->status, ['en cours', 'terminer']);
    }
}
