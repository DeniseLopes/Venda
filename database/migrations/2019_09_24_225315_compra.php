<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Compra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compra', function(Blueprint $table)
		{
			$table->increments('id');
          
            $table->integer('cliente_id')->insigned()->index('fk_cliente1');
			$table->timestamps();
			$table->softDeletes();
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('compra');
    }
}
