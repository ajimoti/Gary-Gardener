<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = ['unit', 'duration'];

    protected $casts = [
        'remind_at' => 'date',
        'unit' => 'string',
        'duration' => 'integer',
    ];

    public function toDoItem(): BelongsTo
    {
        return $this->belongsTo(ToDoItem::class);
    }

    protected static function booted()
    {
        parent::booted();

        static::creating(function ($reminder) {
            $reminder->remind_at = $reminder->toDoItem->generateReminderDate($reminder->unit, $reminder->duration);
        });

        static::saving(function ($reminder) {
            $reminder->remind_at = $reminder->toDoItem->generateReminderDate($reminder->unit, $reminder->duration);
        });
    }
}
