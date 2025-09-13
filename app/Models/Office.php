<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Office extends Model
{
    use SoftDeletes;

    protected $table = 'offices';
    protected $fillable = [
        'officeName', 'officeCode'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'offices_id')->withTrashed();
    }

    public function ics()
    {
        return $this->hasMany(ICS::class, 'offices_id')->withTrashed();
    }

    public function are()
    {
        return $this->hasMany(ARE::class, 'offices_id')->withTrashed();
    }

}
