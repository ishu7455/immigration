<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = ['lead_id', 'file_name', 'file_path'];

    public function lead() {
        return $this->belongsTo(Lead::class);
    }
}
