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
        Schema::create('incomes', function (Blueprint $table) {
            $table->unsignedBigInteger('incomeid')->unique(); //номер поставки
            $table->string('Number', 40); //номер УПД
            $table->date('Date'); //дата поступления
            $table->dateTime('lastChangeDate'); //дата и время обновления информации в сервисе
            $table->string('SupplierArticle', 75); //ваш артикул
            $table->string('TechSize', 30); //размер
            $table->string('Barcode', 30); //штрих-код
            $table->unsignedBigInteger('Quantity'); //кол-во
            $table->float('totalPrice'); //цена из УПД
            $table->date('dateClose'); //дата принятия (закрытия) у нас
            $table->string('warehouseName', 50); //название склада
            $table->unsignedBigInteger('nmid'); //Код WB
            $table->string('status', 50); //Текущий статус поставки

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
        Schema::dropIfExists('incomes');
    }
};
