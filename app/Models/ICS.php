<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ICS extends Model
{
    use SoftDeletes;

    protected $table = 'ics';
    protected $fillable = [
        'offices_id', 'icsOffice', 'icsYear', 'icsCode', 'icsNumber',
        'receivedBy_id', 'receivedByPosition', 'dateReceivedBy',
        'receivedFrom_id', 'receivedFromPosition', 'dateReceivedFrom',
        'furnishedBy', 'remarks'
    ];

    public function receivedBy()
    {
        return $this->belongsTo(ReceivedBy::class, 'receivedBy_id');
    }

    public function receivedFrom()
    {
        return $this->belongsTo(ReceivedFrom::class, 'receivedFrom_id');
    }

    public function office()
    {
        return $this->belongsTo(Office::class, 'offices_id');
    }

    public function information()
    {
        return $this->hasMany(ICSInformation::class, 'ics_id');
    }
}
