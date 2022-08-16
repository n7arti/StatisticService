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
        Schema::create('report_details', function (Blueprint $table) {
            $table->unsignedBigInteger('realizationreport_id'); //Номер отчета
            $table->unsignedBigInteger('suppliercontract_code')->nullable(); //Договор
            $table->unsignedBigInteger('rid'); //Уникальный идентификатор позиции заказа
            $table->date('rr_dt'); //Дата операции
            $table->unsignedBigInteger('rrd_id')->unique(); //Номер строки
            $table->unsignedBigInteger('gi_id'); //Номер поставки
            $table->string('subject_name')->nullable(); //Предмет
            $table->unsignedBigInteger('NM_id')->nullable(); //Артикул
            $table->string('brand_name')->nullable(); //Бренд
            $table->string('sa_name')->nullable(); //Артикул поставщика
            $table->string('ts_name')->nullable(); //Размер
            $table->unsignedBigInteger('barcode'); //Баркод
            $table->string('doc_type_name'); //Тип документа
            $table->unsignedBigInteger('quantity'); //Количество
            $table->float('retail_price'); //Цена розничная
            $table->float('retail_amount'); //Сумма продаж(Возвратов)
            $table->double('sale_percent'); //Согласованная скидка
            $table->double('commission_percent'); //Процент комиссии
            $table->string('office_name')->nullable(); //Склад
            $table->string('supplier_oper_name'); //Обоснование для оплаты
            $table->date('order_dt'); //Даты заказа
            $table->date('sale_dt'); //Дата продажи
            $table->unsignedBigInteger('shk_id'); //ШК
            $table->float('retail_price_withdisc_rub'); //Цена розничная с учетом согласованной скидки
            $table->unsignedBigInteger('delivery_amount'); //Кол-во доставок
            $table->unsignedBigInteger('return_amount'); //Кол-во возвратов
            $table->float('delivery_rub'); //Стоимость логистики
            $table->string('gi_box_type_name'); //Тип коробов
            $table->double('product_discount_for_report'); //Согласованный продуктовый дисконт
            $table->double('supplier_promo'); //Промокод
            $table->float('ppvz_spp_prc'); //Скидка постоянного Покупателя (СПП)
            $table->float('ppvz_kvw_prc_base'); //Размер кВВ без НДС, % Базовый
            $table->float('ppvz_kvw_prc'); //Итоговый кВВ без НДС, %
            $table->float('ppvz_sales_commission'); //Вознаграждение с продаж до вычета услуг поверенного, без НДС
            $table->float('ppvz_for_pay'); //К перечислению Продавцу за реализованный Товар
            $table->float('ppvz_reward'); //Возмещение Расходов услуг поверенного
            $table->float('ppvz_vw'); //Вознаграждение Вайлдберриз (ВВ), без НДС
            $table->float('ppvz_vw_nds'); //НДС с Вознаграждения Вайлдберриз
            $table->unsignedBigInteger('ppvz_office_id'); //Номер офиса
            $table->string('ppvz_office_name')->nullable(); //Наименование офиса доставки
            $table->unsignedBigInteger('ppvz_supplier_id'); //Номер партнера
            $table->string('ppvz_supplier_name'); //Партнер
            $table->string('ppvz_inn'); //ИНН партнера
            $table->string('declaration_number'); //Номер таможенной декларации
            $table->string('bonus_type_name')->nullable(); //Обоснование штрафов и доплат
            $table->char('sticker_id'); //Аналогично стикеру, который клеится на товар в процессе сборки
            $table->string('site_country'); //Страна продажи

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
        Schema::dropIfExists('report_details');
    }
};
