<?php
namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;
    public $timestamps = true;
    protected $table = 'cliente';
    protected $fillable = ['nome'];

    //Relacionamentos
    public function compra(){
        return $this->hasMany('App\Compra');
    }
   
    
}