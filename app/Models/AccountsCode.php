<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AccountsCode extends Model
{
    use SoftDeletes;

    protected $table = 'account_codes';
    protected $fillable = ['propertyCode', 'propertySubCode', 'description'];

    public function areInformation()
    {
        return $this->hasMany(AREInformation::class, 'account_codes_id')->where('propertyYear', session('year'));
    }
}
