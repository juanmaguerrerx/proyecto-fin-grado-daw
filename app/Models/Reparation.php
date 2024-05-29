<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'device_id',
        'reparation_type',
        'price'
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
