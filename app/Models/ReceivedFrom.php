<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ReceivedFrom extends Model
{
    use SoftDeletes;

    protected $table = 'received_from';
    protected $fillable = ['name', 'position'];

    public function ics()
    {
        return $this->hasMany(ICS::class, 'receivedFrom_id')->withTrashed();
    }

    public function are()
    {
        return $this->hasMany(ARE::class, 'receivedFrom_id')->withTrashed();
    }
}
