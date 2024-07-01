<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class SysUser extends Authenticatable
{
    use HasFactory;
    protected $fillable = ['firstname', 'lastname', 'middlename', 'contact', 'address', 'email', 'password', 'type', 'avatar'];
    protected $appends = ['full_name'];
    public function documents() {
        return $this->belongsTo(Document::class, 'user_id', 'id');
    }
    public function scopeGetNorm($q) {
        return $q->where('type', 2)->get();
    }
    public function getFullNameAttribute() {
        return ($this->lastname).' '.($this->firstname).' '.($this->middlename);
    }
}
