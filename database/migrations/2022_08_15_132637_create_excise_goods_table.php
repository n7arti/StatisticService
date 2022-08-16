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
        Schema::create('excise_goods', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->unique(); //внутренний код операции
            $table->unsignedBigInteger('inn'); //ИНН поставщика
            $table->float('finishedPrice'); //цена товара с учетом НДС
            $table->unsignedBigInteger('operationTypeId'); //тип операции (тип операции 1 - продажа, 2 - возврат)
            $table->dateTime('fiscalDt'); //время фискализации
            $table->unsignedBigInteger('docNumber'); //номер фискального документа
            $table->unsignedBigInteger('fnNumber');//номер фискального накопителя
            $table->unsignedBigInteger('regNumber'); //регистрационный номер ККТ
            $table->string('excise'); //акциз (он же киз)
            $table->dateTime('date'); //дата, когда данные появились в системе (по ним и отслеживать изменение, появление новых)

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('excise_goods');
    }
};
