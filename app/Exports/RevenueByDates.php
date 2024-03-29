<?php

namespace App\Exports;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;

class RevenueByDates implements FromQuery
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function __construct(string $startDate, string $endDate, string $storeId)
    {
        $this->start_date = $startDate;
        $this->end_date = $endDate;
        $this->store_id = $storeId;
    }

    public function query()
    {
        $endDate = Carbon::parse($this->end_date)->addDay()->format('Y-m-d');

        $revenuesByDate = DB::table('orders')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
            ->where('status', 'succeed')
            ->whereBetween('created_at', [$this->start_date, $endDate])
            ->where('store_id', $this->store_id)
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy(DB::raw('DATE(created_at)'));


        logger($revenuesByDate->get());

        return $revenuesByDate;
    }
}
