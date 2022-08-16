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
        Schema::create('sales', function (Blueprint $table) {
            $table->string('gNumber', 50); //номер заказа
            $table->date('Date'); //дата продажи
            $table->dateTime('lastChangeDate'); //дата время обновления информации в сервисе
            $table->string('supplierArticle', 75); //ваш артикул
            $table->string('techSize', 30); //размер
            $table->string('barcode', 30); //штрих-код
            $table->float('totalPrice'); //начальная розничная цена товара
            $table->double('discountPercent'); // согласованная скидка на товар
            $table->unsignedBigInteger('isSupply'); //договор поставки
            $table->unsignedBigInteger('isRealization'); //договор реализации
            $table->double('promoCodeDiscount'); //согласованный промокод
            $table->string('warehouseName', 50); //склад отгрузки
            $table->string('countryName', 200); //страна
            $table->string('oblastOkrugName', 200); //округ
            $table->string('regionName', 200); //регион
            $table->unsignedBigInteger('incomeID'); //номер поставки
            $table->string('saleID', 15)->unique(); //уникальный идентификатор продажи/возврата
            $table->unsignedBigInteger('Odid'); //уникальный идентификатор позиции заказа
            $table->double('spp'); //согласованная скидка постоянного покупателя (СПП)
            $table->float('forpay'); //к перечислению поставщику
            $table->float('finished_price'); //фактическая цена из заказа (с учетом всех скидок, включая и от ВБ)
            $table->float('pricewithdisc'); //цена, от которой считается вознаграждение поставщика forpay (с учетом всех согласованных скидок)
            $table->unsignedBigInteger('nmId'); //код WB
            $table->string('subject', 500); //предмет
            $table->string('category', 50); //категория
            $table->string('brand', 50); //бренд
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
        Schema::dropIfExists('sales');
    }
};
