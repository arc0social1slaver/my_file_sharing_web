<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'description', 'file_json', 'user_id'];
    protected $appends = ['user_name', 'list_file'];
    public function users() {
        return $this->hasOne(SysUser::class, 'id', 'user_id');
    }
    public function getUserNameAttribute() {
        return $this->users->full_name;
    }
    public function getListFileAttribute() {
        return json_decode($this->file_json);
    }
    public function scopeGetDocs($q, $id) {
        return $q->where('user_id', $id)->get();
    }
    public function scopeAllDocs($q, $type) {
        if($type == 1) {
            return $q->whereIn('user_id', SysUser::select(['id']))->orderBy('created_at', 'desc');
        }
        return $q->where('user_id', auth('my_sys')->id())->orderBy('created_at', 'desc');
    }
}
