<?php

namespace App\Exports;

use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;

class ProductByDates implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct(string $startDate, string $endDate, string $storeId)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->store_id = $storeId;
    }

    public function query()
    {
        $endDate = Carbon::parse($this->end_date)->addDay()->format('Y-m-d');

        $productQuantitiesByDate = DB::table('orders')
            ->join('order_items', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', '=', 'succeed')
            ->whereBetween('orders.created_at', [$this->start_date, $endDate])
            ->where('orders.store_id', '=', $this->store_id)
            ->groupBy('order_items.product_id')
            ->groupBy('orders.created_at')
            ->groupBy('products.id')
            ->groupBy('products.name')
            ->groupBy('products.price')
            ->select('products.name', \DB::raw('SUM(order_items.qty) as qty'), \DB::raw('(products.price * SUM(order_items.qty)) as price'), 'orders.created_at')
            ->orderBy('orders.created_at');

        return $productQuantitiesByDate;
    }
}
