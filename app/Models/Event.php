<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'era_id',
        'title',
        'start_year',
        'end_year',
        'location',
        'key_figures',
        'description'
    ];

    public function era() {
        return $this->belongsTo(Era::class);
    }
}