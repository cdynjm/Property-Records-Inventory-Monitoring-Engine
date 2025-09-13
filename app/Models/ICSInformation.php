<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ICSInformation extends Model
{
    use SoftDeletes;

    protected $table = 'ics_information';
    protected $fillable = [
        'ics_id', 'quantity', 'unit', 'description', 'officeCode',
        'invItemNumber', 'dateAcquired', 'estUsefulLife', 'unitCost'
    ];

    public function ics()
    {
        return $this->belongsTo(ICS::class, 'ics_id')->withTrashed();
    }
}
