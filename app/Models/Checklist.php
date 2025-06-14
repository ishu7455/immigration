<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checklist extends Model
{
    protected $fillable = ['lead_id', 'item', 'is_complete'];

    public function lead() {
        return $this->belongsTo(Lead::class);
    }
}
