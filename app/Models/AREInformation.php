<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AREInformation extends Model
{
    use SoftDeletes;

    protected $table = 'are_information';
    protected $fillable = [
        'are_id', 'quantity', 'unit', 'description',
        'propertyYear', 'propertyCode', 'propertySubCode',
        'properyCount', 'propertyOffice', 'propertyNumber',
        'unitCost', 'totalValue', 'dateAcquired'
    ];

    public function are()
    {
        return $this->belongsTo(ARE::class, 'are_id')->withTrashed();
    }
}
