<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $primaryKey = 'unique_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'deleted_at' => 'datetime:Y-m-d H:m:s',
        'created_at' => 'datetime:Y-m-d H:m:s',
        'updated_at' => 'datetime:Y-m-d H:m:s'
    ];

    protected $fillable = [
        'unique_id','name','photo_url','version','transaction_type','deleted_at','created_at','updated_at','user_id'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class,"category_id");
    }

    public function User(){
        return $this->belongsTo(User::class,"user_id","google_user_id");
    }
}
