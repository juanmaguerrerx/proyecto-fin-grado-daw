<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            // Agrega un nuevo campo booleano llamado 'admin'
            $table->boolean('admin')->default(false)->after('password');
            
            // Elimina los campos 'address', 'province' y 'zip_code'
            $table->dropColumn(['address', 'province', 'zip_code']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            // Si necesitas revertir los cambios, aquí puedes hacerlo
            $table->string('address')->nullable()->after('phone');
            $table->string('province')->nullable()->after('address');
            $table->integer('zip_code')->nullable()->after('province');
            $table->dropColumn('admin');
        });
    }
};
