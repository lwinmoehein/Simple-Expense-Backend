<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
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
        'unique_id','amount','note','category_id','version','type','created_at','updated_at','user_id'
    ];

    public function category(){
        return $this->belongsTo(Category::class,"category_id");
    }
    public function User(){
        return $this->belongsTo(User::class,"user_id","google_user_id");
    }
}
