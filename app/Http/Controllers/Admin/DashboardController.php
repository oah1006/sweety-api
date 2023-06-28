<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RevenueByDates;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function compareRevenue(Request $request) {
        $today = date('Y-m-d');
        $yesterday = date('Y-m-d', strtotime('-1 day'));
        $nowMonth = date('m');
        $previousMonth = date('m', strtotime('-1 month'));
        $nowYear = date('Y');

        $percentChangeDay = 0;
        $percentChangeMonth = 0;

        $revenueToday = Order::whereDate('created_at', $today)->sum('total');
        $revenueYesterday = Order::whereDate('created_at', $yesterday)->sum('total');


        $revenueNowMonth = Order::whereYear('created_at', $nowYear)
            ->whereMonth('created_at', $nowMonth)
            ->sum('total');

        $revenuePreviousMonth = Order::whereYear('created_at', $nowYear)
            ->whereMonth('created_at', $previousMonth)
            ->sum('total');

        if ($revenueYesterday > 0) {
            $percentChangeDay = round((($revenueToday - $revenueYesterday) / $revenueYesterday) * 100);
        }

        if ($revenuePreviousMonth > 0) {
            $percentChangeMonth =
                round((($revenueNowMonth - $revenuePreviousMonth) / $revenuePreviousMonth) * 100);
        }

        return response()->json([
            'revenueToday' => $revenueToday,
            'revenueYesterday' => $revenueYesterday,
            'revenueNowMonth' => $revenueNowMonth,
            'revenuePreviousMonth' => $revenuePreviousMonth,
            'percentChangeDay' => $percentChangeDay,
            'percentChangeMonth' => $percentChangeMonth
        ]);
    }

    public function totalProduct(Request $request) {
        $products = Product::all();

        $totalProducts = $products->count();

        return response()->json([
            'totalProducts' => $totalProducts
        ]);
    }

    public function totalOrder(Request $request) {
        $pendingOrder = Order::where('status', 'pending')->count();
        $canceledOrder = Order::where('status', 'canceled')->count();
        $acceptedOrder = Order::where('status', 'accepted')->count();
        $preparingOrder = Order::where('status', 'preparing')->count();
        $preparedOrder = Order::where('status', 'prepared')->count();
        $deliveringOrder = Order::where('status', 'delivering')->count();
        $succeedOrder = Order::where('status', 'succeed')->count();
        $failedOrder = Order::where('status', 'failed')->count();


        $today = date('Y-m-d');
        $totalOrderToday = Order::whereDate('created_at', $today)->count();

        $nowMonth = date('m');
        $nowYear = date('Y');
        $totalOrderMonth = Order::whereYear('created_at', $nowYear)
            ->whereMonth('created_at', $nowMonth)
            ->count();

        $totalOrder = Order::all()->count();

        return response()->json([
            'countStatus' => [
                $pendingOrder,
                $canceledOrder,
                $acceptedOrder,
                $preparingOrder,
                $preparedOrder,
                $deliveringOrder,
                $succeedOrder,
                $failedOrder,
            ],
            'totalOrder' => $totalOrder,
            'totalOrderToday' => $totalOrderToday,
            'totalOrderMonth' => $totalOrderMonth
        ]);
    }

    public function indexBestSeller(Request $request) {
        $bestSellingProducts = DB::table('order_items')
            ->select('product_id', DB::raw('SUM(qty) as total_quantity'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'succeed')
            ->groupBy('product_id')
            ->orderByDesc('total_quantity')
            ->take(10)
            ->get();

        $productIds = $bestSellingProducts->pluck('product_id');

        $products = Product::whereIn('id', $productIds)->get();

        return response()->json([
            'data' => $products
        ]);
    }

    public function calculateRevenueByDates(Request $request) {
        if ($request->filled('store_id')) {
            $storeId = $request->store_id;
            $revenuesOfTheLastSevenDays = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
                ->where('status', 'succeed')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->where('store_id', '=', $storeId)
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->get();
        } else {
            $revenuesOfTheLastSevenDays = DB::table('orders')
                ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total) as revenue'))
                ->where('status', 'succeed')
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy(DB::raw('DATE(created_at)'))
                ->orderBy(DB::raw('DATE(created_at)'))
                ->get();
        }

        if ($request->filled('store_id')) {
            $storeId = $request->store_id;
            $revenuesOfTheLastSevenMonth = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total) as revenue'))
                ->where('status', 'succeed')
                ->where('store_id', '=', $storeId)
                ->where('created_at', '>=', Carbon::now()->subMonths(7))
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                ->get();
        } else {
            $revenuesOfTheLastSevenMonth = DB::table('orders')
                ->select(DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'), DB::raw('SUM(total) as revenue'))
                ->where('status', 'succeed')
                ->where('created_at', '>=', Carbon::now()->subMonths(7))
                ->groupBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                ->orderBy(DB::raw('DATE_FORMAT(created_at, "%Y-%m")'))
                ->get();
        }


        return response()->json([
            '7 days' => $revenuesOfTheLastSevenDays,
            '7 months' => $revenuesOfTheLastSevenMonth
        ]);
    }

    public function getProductByDates(Request $request) {
        $startDate = Carbon::today()->subDays(7);
        $startMonth = Carbon::now()->subMonths(7);

        if ($request->filled('store_id')) {
            $storeId = $request->store_id;
            $productTotalByDates = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', '=', 'succeed')
                ->where('orders.created_at', '>=', $startDate)
                ->where('orders.store_id', '=', $storeId)
                ->groupBy('order_items.product_id')
                ->groupBy('products.id')
                ->groupBy('products.name')
                ->groupBy('products.price')
                ->select('order_items.product_id', \DB::raw('SUM(order_items.qty) as qty'), 'products.id', 'products.name', 'products.price')
                ->get();
        } else {
            $productTotalByDates = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', '=', 'succeed')
                ->where('orders.created_at', '>=', $startDate)
                ->groupBy('order_items.product_id')
                ->groupBy('products.id')
                ->groupBy('products.name')
                ->groupBy('products.price')
                ->select('order_items.product_id', \DB::raw('SUM(order_items.qty) as qty'), 'products.id', 'products.name', 'products.price')
                ->get();
        }

        if ($request->filled('store_id')) {
            $storeId = $request->store_id;
            $productTotalByMonths = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', '=', 'succeed')
                ->where('orders.created_at', '>=', $startMonth)
                ->where('orders.store_id', '=', $storeId)
                ->groupBy('order_items.product_id')
                ->groupBy('products.id')
                ->groupBy('products.name')
                ->groupBy('products.price')
                ->select('order_items.product_id', \DB::raw('SUM(order_items.qty) as qty'), 'products.id', 'products.name', 'products.price')
                ->get();
        } else {
            $productTotalByMonths = DB::table('orders')
                ->join('order_items', 'orders.id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->where('orders.status', '=', 'succeed')
                ->where('orders.created_at', '>=', $startMonth)
                ->groupBy('order_items.product_id')
                ->groupBy('products.id')
                ->groupBy('products.name')
                ->groupBy('products.price')
                ->select('order_items.product_id', \DB::raw('SUM(order_items.qty) as qty'), 'products.id', 'products.name', 'products.price')
                ->get();
        }

        return response()->json([
            '7 days' => $productTotalByDates,
            '7 months' => $productTotalByMonths
        ]);
    }

    public function exportRevenueByInputDate(Request $request) {
        logger((new RevenueByDates($request->query('start_date'), $request->query('start_date'), $request->query('store_id')))->download('revenue.xlsx'));
        return (new RevenueByDates($request->query('start_date'), $request->query('start_date'), $request->query('store_id')))->download('revenue.xlsx');
    }

}
