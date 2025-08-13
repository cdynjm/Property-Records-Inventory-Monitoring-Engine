<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ARE extends Model
{
    use SoftDeletes;

    protected $table = 'are';
    protected $fillable = [
        'areOffice', 'areYear', 'areCode', 'areControlNumber',
        'receivedFrom_id', 'receivedFromPosition', 'dateReceivedFrom',
        'receivedBy_id', 'receivedByPosition', 'dateReceivedBy',
        'furnishedBy', 'remarks'
    ];

    public function receivedFrom()
    {
        return $this->belongsTo(ReceivedFrom::class, 'receivedFrom_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(ReceivedBy::class, 'receivedBy_id');
    }

    public function information()
    {
        return $this->hasMany(AREInformation::class, 'are_id');
    }
}
