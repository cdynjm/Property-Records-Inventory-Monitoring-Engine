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
        'account_codes_id', 'propertyYear', 'propertyCode', 'propertySubCode',
        'propertyCount', 'propertyOffice', 'propertyNumber',
        'unitCost', 'totalValue', 'dateAcquired'
    ];

    public function are()
    {
        return $this->belongsTo(ARE::class, 'are_id');
    }

    public function accountsCode()
    {
        return $this->belongsTo(AccountsCode::class, 'account_codes_id');
    }
}
