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
        Schema::create('stocks', function (Blueprint $table) {
            //$table->id();
            $table->dateTime('lastChangeDate'); //дата и время обновления информациив сервисе
            $table->string('supplierArticle',75); //артикул поставщика
            $table->string('techSize',30); //размер
            $table->string('Barcode',30); //штрих-код
            $table->unsignedBigInteger('Quantity'); //кол-во доступное для продажи
            $table->unsignedBigInteger('isSupply'); //договор поставки
            $table->unsignedBigInteger('isRealization'); //договор реализации
            $table->unsignedBigInteger('quantityFull'); //кол-во полное
            $table->unsignedBigInteger('quantityNotInOrders'); //кол-во не в заказе
            $table->string('warehouseName',50); //название склада
            $table->unsignedBigInteger('inWayToClient'); //в пути к клиенту (штук)
            $table->unsignedBigInteger('inWayFromClient'); //в пути от клиента (штук)
            $table->unsignedBigInteger('nmid'); //код WB
            $table->string('subject',50); //предмет
            $table->string('category',50); //категория
            $table->unsignedBigInteger('DaysOnSite'); //кол-во дней на сайте
            $table->string('brand', 50); //бренд
            $table->string('SCCode',50); //код контракта
            $table->unsignedBigInteger('Warehouse'); //уникальный идентификатор склада
            $table->float('Price'); //цена товара
            $table->unsignedBigInteger('Discount'); //скидка на товар установленная продавцом
            $table->primary(['nmid', 'Warehouse']);
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
        Schema::dropIfExists('stocks');
    }
};
