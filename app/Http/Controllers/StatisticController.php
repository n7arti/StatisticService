<?php

namespace App\Http\Controllers;

use App\Models\ExciseGood;
use App\Models\Income;
use App\Models\Order;
use App\Models\ReportDetail;
use App\Models\Sale;
use App\Models\Stock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StatisticController extends Controller
{
    private string $apiUrl = 'https://suppliers-stats.wildberries.ru/api/v1/supplier/';
    private string $token = 'MzY1MDJkYzUtYTM0MS00ZWZhLWE5ZDktMzc1YjZmMWIxMmVl';
    private string $dateFrom = '2022-06-01T00:00:00Z';
    private string $dateTo = '2022-08-15T00:00:00Z';

    public function getStatistic()
    {
        $data['dateFrom'] = $this->dateFrom;
        $data['key'] = $this->token;

        $this->addIncomes($this->getData($data, 'incomes'));
        $this->addStocks($this->getData($data, 'stocks'));
        $this->addOrders($this->getData($data, 'orders'));
        $this->addSales($this->getData($data, 'sales'));
        $this->addExciseGoods($this->getData($data, 'excise-goods'));
        $data['dateTo'] = $this->dateTo;
        $data['limit'] = 1000;
        $data['rrdid'] = 0;
        do {
            $reportDetails = $this->getData($data, 'reportDetailByPeriod');
            $reportDetails = json_decode($reportDetails, true);
            if ($reportDetails != null) {
                foreach ($reportDetails as $reportDetail) {
                    if ($reportDetail["rrd_id"] > $data['rrdid'])
                        $data['rrdid'] = $reportDetail["rrd_id"];
                    if (array_key_exists('ppvz_office_name', $reportDetail))
                        $this->addReportDetail($reportDetail);
                    else $this->addReportDetailWithoutField($reportDetail);
                }

            }
        } while ($reportDetails != null);
        echo 'Данные успешно выгружены';
    }

    //Выгрузка данных с API
    public function getData($data, $path): string
    {
        $url = $this->apiUrl . $path . '?' . http_build_query($data);
        //echo $url.'</br>';
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);

        return $output;
    }

    public function addIncomes($incomes)
    {
        $incomes = json_decode($incomes, true);
        if ($incomes != null) {
            foreach ($incomes as $income) {
                try {
                    Income::create([
                        'incomeid' => $income["incomeid"],
                        'Number' => $income["Number"],
                        'Date' => $income["Date"],
                        'lastChangeDate' => $income["lastChangeDate"],
                        'SupplierArticle' => $income["SupplierArticle"],
                        'TechSize' => $income["TechSize"],
                        'Barcode' => $income["Barcode"],
                        'Quantity' => $income["Quantity"],
                        'totalPrice' => $income["totalPrice"],
                        'dateClose' => $income["dateClose"],
                        'warehouseName' => $income["warehouseName"],
                        'nmid' => $income["nmid"],
                        'status' => $income["status"],
                    ]);
                } catch (\Exception $exception) {
                    Log::alert(__METHOD__ . ':' . $exception->getMessage());
                    continue;
                }
            }
        }
    }

    public function addStocks($stocks)
    {
        $stocks = json_decode($stocks, true);
        if ($stocks != null) {
            foreach ($stocks as $stock) {
                try {
                    Stock::create([
                        'lastChangeDate' => $stock["lastChangeDate"],
                        'supplierArticle' => $stock["supplierArticle"],
                        'techSize' => $stock["techSize"],
                        'Barcode' => $stock["barcode"],
                        'Quantity' => $stock["quantity"],
                        'isSupply' => $stock["isSupply"],
                        'isRealization' => $stock["isRealization"],
                        'quantityFull' => $stock["quantityFull"],
                        'quantityNotInOrders' => $stock["quantityNotInOrders"],
                        'warehouseName' => $stock["warehouseName"],
                        'inWayToClient' => $stock["inWayToClient"],
                        'inWayFromClient' => $stock["inWayFromClient"],
                        'nmid' => $stock["nmId"],
                        'subject' => $stock["subject"],
                        'category' => $stock["category"],
                        'DaysOnSite' => $stock["daysOnSite"],
                        'brand' => $stock["brand"],
                        'SCCode' => $stock["SCCode"],
                        'Warehouse' => $stock["warehouse"],
                        'Price' => $stock["Price"],
                        'Discount' => $stock["Discount"]
                    ]);
                } catch (\Exception $exception) {
                    Log::alert(__METHOD__ . ':' . $exception->getMessage());
                    continue;
                }
            }
        }
    }

    public function addOrders($orders)
    {
        $orders = json_decode($orders, true);
        if ($orders != null) {
            foreach ($orders as $order) {
                try {
                    Order::create([
                        'gNumber' => $order["gNumber"],
                        'date' => $order["date"],
                        'lastChangeDate' => $order["lastChangeDate"],
                        'supplierArticle' => $order["supplierArticle"],
                        'techSize' => $order["techSize"],
                        'barcode' => $order["barcode"],
                        'totalPrice' => $order["totalPrice"],
                        'discountPercent' => $order["discountPercent"],
                        'warehouseName' => $order["warehouseName"],
                        'oblast' => $order["oblast"],
                        'incomeID' => $order["incomeID"],
                        'odid' => $order["odid"],
                        'nmid' => $order["nmId"],
                        'subject' => $order["subject"],
                        'category' => $order["category"],
                        'brand' => $order["brand"],
                        'is_cancel' => $order["isCancel"],
                        'sticker' => $order["sticker"]
                    ]);
                } catch (\Exception $exception) {
                    Log::alert(__METHOD__ . ':' . $exception->getMessage());
                    continue;
                }
            }
        }
    }

    public function addSales($sales)
    {
        $sales = json_decode($sales, true);
        if ($sales != null) {
            foreach ($sales as $sale) {
                try {
                    Sale::create([
                        'gNumber' => $sale["gNumber"],
                        'Date' => $sale["date"],
                        'lastChangeDate' => $sale["lastChangeDate"],
                        'supplierArticle' => $sale["supplierArticle"],
                        'techSize' => $sale["techSize"],
                        'barcode' => $sale["barcode"],
                        'totalPrice' => $sale["totalPrice"],
                        'discountPercent' => $sale["discountPercent"],
                        'isSupply' => $sale["isSupply"],
                        'isRealization' => $sale["isRealization"],
                        'promoCodeDiscount' => $sale["promoCodeDiscount"],
                        'warehouseName' => $sale["warehouseName"],
                        'countryName' => $sale["countryName"],
                        'oblastOkrugName' => $sale["oblastOkrugName"],
                        'regionName' => $sale["regionName"],
                        'incomeID' => $sale["incomeID"],
                        'saleID' => $sale["saleID"],
                        'Odid' => $sale["odid"],
                        'spp' => $sale["spp"],
                        'forpay' => $sale["forPay"],
                        'finished_price' => $sale["finishedPrice"],
                        'pricewithdisc' => $sale["priceWithDisc"],
                        'nmId' => $sale["nmId"],
                        'subject' => $sale["subject"],
                        'category' => $sale["category"],
                        'brand' => $sale["brand"],
                        'sticker' => $sale["sticker"]
                    ]);
                } catch (\Exception $exception) {
                    Log::alert(__METHOD__ . ':' . $exception->getMessage());
                    continue;
                }
            }
        }
    }

    public function addExciseGoods($exciseGoods)
    {
        $exciseGoods = json_decode($exciseGoods, true);
        if ($exciseGoods != null) {
            foreach ($exciseGoods as $exciseGood) {
                try {
                    ExciseGood::create([
                        'id' => $exciseGood["id"],
                        'inn' => $exciseGood["inn"],
                        'finishedPrice' => $exciseGood["finishedPrice"],
                        'operationTypeId' => $exciseGood["operationTypeId"],
                        'fiscalDt' => $exciseGood["fiscalDt"],
                        'docNumber' => $exciseGood["docNumber"],
                        'fnNumber' => $exciseGood["fnNumber"],
                        'regNumber' => $exciseGood["regNumber"],
                        'excise' => $exciseGood["excise"],
                        'date' => $exciseGood["date"],
                    ]);
                } catch (\Exception $exception) {
                    Log::alert(__METHOD__ . ':' . $exception->getMessage());
                    continue;
                }
            }
        }
    }

    public function addReportDetail($reportDetail)
    {
        try {
            ReportDetail::create([
                'realizationreport_id' => $reportDetail["realizationreport_id"],
                'suppliercontract_code' => $reportDetail["suppliercontract_code"],
                'rid' => $reportDetail["rid"],
                'rr_dt' => $reportDetail["rr_dt"],
                'rrd_id' => $reportDetail["rrd_id"],
                'gi_id' => $reportDetail["gi_id"],
                'subject_name' => $reportDetail["subject_name"],
                'NM_id' => $reportDetail["nm_id"],
                'brand_name' => $reportDetail["brand_name"],
                'sa_name' => $reportDetail["sa_name"],
                'ts_name' => $reportDetail["ts_name"],
                'barcode' => $reportDetail["barcode"],
                'doc_type_name' => $reportDetail["doc_type_name"],
                'quantity' => $reportDetail["quantity"],
                'retail_price' => $reportDetail["retail_price"],
                'retail_amount' => $reportDetail["retail_amount"],
                'sale_percent' => $reportDetail["sale_percent"],
                'commission_percent' => $reportDetail["commission_percent"],
                'office_name' => $reportDetail["office_name"],
                'supplier_oper_name' => $reportDetail["supplier_oper_name"],
                'order_dt' => $reportDetail["order_dt"],
                'sale_dt' => $reportDetail["sale_dt"],
                'shk_id' => $reportDetail["shk_id"],
                'retail_price_withdisc_rub' => $reportDetail["retail_price_withdisc_rub"],
                'delivery_amount' => $reportDetail["delivery_amount"],
                'return_amount' => $reportDetail["return_amount"],
                'delivery_rub' => $reportDetail["delivery_rub"],
                'gi_box_type_name' => $reportDetail["gi_box_type_name"],
                'product_discount_for_report' => $reportDetail["product_discount_for_report"],
                'supplier_promo' => $reportDetail["supplier_promo"],
                'ppvz_spp_prc' => $reportDetail["ppvz_spp_prc"],
                'ppvz_kvw_prc_base' => $reportDetail["ppvz_kvw_prc_base"],
                'ppvz_kvw_prc' => $reportDetail["ppvz_kvw_prc"],
                'ppvz_sales_commission' => $reportDetail["ppvz_sales_commission"],
                'ppvz_for_pay' => $reportDetail["ppvz_for_pay"],
                'ppvz_reward' => $reportDetail["ppvz_reward"],
                'ppvz_vw' => $reportDetail["ppvz_vw"],
                'ppvz_vw_nds' => $reportDetail["ppvz_vw_nds"],
                'ppvz_office_id' => $reportDetail["ppvz_office_id"],
                'ppvz_office_name' => $reportDetail["ppvz_office_name"],
                'ppvz_supplier_id' => $reportDetail["ppvz_supplier_id"],
                'ppvz_supplier_name' => $reportDetail["ppvz_supplier_name"],
                'ppvz_inn' => $reportDetail["ppvz_inn"],
                'declaration_number' => $reportDetail["declaration_number"],
                'sticker_id' => $reportDetail["sticker_id"],
                'site_country' => $reportDetail["site_country"]
            ]);
        } catch (\Exception $exception) {
            Log::alert(__METHOD__ . ':' . $exception->getMessage());
        }

    }

    public function addReportDetailWithoutField($reportDetail)
    {
        try {
            ReportDetail::create([
                'realizationreport_id' => $reportDetail["realizationreport_id"],
                'suppliercontract_code' => $reportDetail["suppliercontract_code"],
                'rid' => $reportDetail["rid"],
                'rr_dt' => $reportDetail["rr_dt"],
                'rrd_id' => $reportDetail["rrd_id"],
                'gi_id' => $reportDetail["gi_id"],
                'subject_name' => $reportDetail["subject_name"],
                'NM_id' => $reportDetail["nm_id"],
                'brand_name' => $reportDetail["brand_name"],
                'sa_name' => $reportDetail["sa_name"],
                'ts_name' => $reportDetail["ts_name"],
                'barcode' => $reportDetail["barcode"],
                'doc_type_name' => $reportDetail["doc_type_name"],
                'quantity' => $reportDetail["quantity"],
                'retail_price' => $reportDetail["retail_price"],
                'retail_amount' => $reportDetail["retail_amount"],
                'sale_percent' => $reportDetail["sale_percent"],
                'commission_percent' => $reportDetail["commission_percent"],
                'office_name' => $reportDetail["office_name"],
                'supplier_oper_name' => $reportDetail["supplier_oper_name"],
                'order_dt' => $reportDetail["order_dt"],
                'sale_dt' => $reportDetail["sale_dt"],
                'shk_id' => $reportDetail["shk_id"],
                'retail_price_withdisc_rub' => $reportDetail["retail_price_withdisc_rub"],
                'delivery_amount' => $reportDetail["delivery_amount"],
                'return_amount' => $reportDetail["return_amount"],
                'delivery_rub' => $reportDetail["delivery_rub"],
                'gi_box_type_name' => $reportDetail["gi_box_type_name"],
                'product_discount_for_report' => $reportDetail["product_discount_for_report"],
                'supplier_promo' => $reportDetail["supplier_promo"],
                'ppvz_spp_prc' => $reportDetail["ppvz_spp_prc"],
                'ppvz_kvw_prc_base' => $reportDetail["ppvz_kvw_prc_base"],
                'ppvz_kvw_prc' => $reportDetail["ppvz_kvw_prc"],
                'ppvz_sales_commission' => $reportDetail["ppvz_sales_commission"],
                'ppvz_for_pay' => $reportDetail["ppvz_for_pay"],
                'ppvz_reward' => $reportDetail["ppvz_reward"],
                'ppvz_vw' => $reportDetail["ppvz_vw"],
                'ppvz_vw_nds' => $reportDetail["ppvz_vw_nds"],
                'ppvz_office_id' => $reportDetail["ppvz_office_id"],
                'ppvz_supplier_id' => $reportDetail["ppvz_supplier_id"],
                'ppvz_supplier_name' => $reportDetail["ppvz_supplier_name"],
                'ppvz_inn' => $reportDetail["ppvz_inn"],
                'declaration_number' => $reportDetail["declaration_number"],
                'sticker_id' => $reportDetail["sticker_id"],
                'site_country' => $reportDetail["site_country"]
            ]);
        } catch (\Exception $exception) {
            Log::alert(__METHOD__ . ':' . $exception->getMessage());
        }

    }
}
