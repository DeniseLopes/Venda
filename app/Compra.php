<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Compra extends Model
{
    use SoftDeletes;
    protected $table = 'compra';
    protected $fillable = ['data', 'cliente_id'];
  

    public function Cliente(){
        return $this->belongsTo('App\Cliente');
    }
}
