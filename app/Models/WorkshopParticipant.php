<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\softDeletes;


class WorkshopParticipant extends Model
{
    use HasFactory, softDeletes;

    protected $table = 'workshop_participants';

    protected $fillable = [
        'name',
        'occupation',
        'email',
        'workshop_id',
        'booking_transaction_id',
    ];

    public function workshop(): BelongsTo
    {
        return $this->belongsTo(Workshop::class, 'workshop_id');
    }

    public function bookingTransaction(): BelongsTo
    {
        return $this->belongsTo(bookingTransaction::class, 'booking_transaction_id');
    }

}
