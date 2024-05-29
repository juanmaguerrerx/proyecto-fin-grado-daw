<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'user_id',
        'reparation_id',
        'order_date',
        'status',
        'reparation_date'
    ];

    public function reparation()
    {
        return $this->belongsTo(Reparation::class);
    }
}
