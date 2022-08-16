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
        Schema::create('orders', function (Blueprint $table) {
            $table->string('gNumber', 50); //номер заказа
            $table->date('date'); //дата заказа
            $table->dateTime('lastChangeDate'); //дата время обновления информации в сервисе
            $table->string('supplierArticle', 75); //ваш артикул
            $table->string('techSize', 30); //размер
            $table->string('barcode', 30); //штрих-код
            $table->float('totalPrice'); //цена до согласованной скидки/промо/спп
            $table->unsignedBigInteger('discountPercent'); //согласованный итоговый дисконт
            $table->string('warehouseName', 50); //склад отгрузки
            $table->string('oblast', 200); //область
            $table->unsignedBigInteger('incomeID'); //номер поставки
            $table->unsignedBigInteger('odid')->unique(); //уникальный идентификатор позиции заказа
            $table->unsignedBigInteger('nmid'); //Код WB
            $table->string('subject', 50); //предмет
            $table->string('category', 50); //категория
            $table->string('brand', 50); //бренд
            $table->unsignedBigInteger('is_cancel'); //Отмена заказа. 1 – заказ отменен до оплаты
            $table->char('sticker'); //аналогично стикеру, который клеится на товар в процессе сборки

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
        Schema::dropIfExists('orders');
    }
};
