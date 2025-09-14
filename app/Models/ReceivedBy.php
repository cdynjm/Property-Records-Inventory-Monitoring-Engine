<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedBy extends Model
{
    use SoftDeletes;

    protected $table = 'received_by';
    protected $fillable = ['name', 'position'];

    public function ics()
    {
        return $this->hasMany(ICS::class, 'receivedBy_id');
    }

    public function are()
    {
        return $this->hasMany(ARE::class, 'receivedBy_id');
    }
}
