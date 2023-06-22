<?php

namespace App\Models;

use App\Events\AppointmentCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Appointment extends Model
{
    use HasFactory;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected $fillable = [
        'date',
        'time',
        'car_brand',
        'issue',
        'status'
    ];

    protected $dispatchesEvents = [
        'created' => AppointmentCreated::class,
    ];
}
