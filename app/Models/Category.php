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
    protected $dates = ["deleted_at"];

    protected $fillable = [
        'unique_id','name','photo_url','version','transaction_type','deleted_at','created_at','updated_at'
    ];

    public function transactions(){
        return $this->hasMany(Transaction::class,"category_id");
    }
}
