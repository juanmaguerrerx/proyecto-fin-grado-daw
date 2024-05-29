<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Models;
use Pest\Arch\Support\ReflectionClassForFunction;

class Device extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        'name',
        'type',
        'model_id',
        'reference'
    ];
    public function model()
    {
        return $this->belongsTo(Models::class);
    }
}
