<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ARE extends Model
{
    use SoftDeletes;

    protected $table = 'are';
    protected $fillable = [
        'offices_id', 'areOffice', 'areYear', 'areCode', 'areControlNumber',
        'receivedFrom_id', 'receivedFromPosition', 'dateReceivedFrom',
        'receivedBy_id', 'receivedBy', 'receivedByPosition', 'dateReceivedBy',
        'furnishedBy', 'remarks', 'scannedDocument'
    ];

    public function receivedFrom()
    {
        return $this->belongsTo(ReceivedFrom::class, 'receivedFrom_id');
    }

    public function receivedBy()
    {
        return $this->belongsTo(ReceivedBy::class, 'receivedBy_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'offices_id');
    }

    public function information()
    {
        return $this->hasMany(AREInformation::class, 'are_id');
    }
}
