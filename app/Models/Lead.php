<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    protected $fillable = ['name', 'email', 'phone', 'uci', 'case_type'];

    public function checklists() {
        return $this->hasMany(Checklist::class);
    }

    public function documents() {
        return $this->hasMany(Document::class);
    }
}
