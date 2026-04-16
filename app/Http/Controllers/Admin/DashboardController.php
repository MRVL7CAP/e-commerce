<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSales = Order::where('status', 'paid')->sum('total_amount');
        $totalOrders = Order::count();
        $paidOrders = Order::where('status', 'paid')->count();

        $salesByQuarter = Order::where('status', 'paid')
            ->get(['created_at', 'total_amount'])
            ->groupBy(function ($order) {
                $year = $order->created_at->year;
                $quarter = (int) ceil($order->created_at->month / 3);

                return sprintf('%04d-%d', $year, $quarter);
            })
            ->map(function ($orders, $key) {
                [$year, $quarter] = explode('-', $key);

                return (object) [
                    'quarter' => "T{$quarter} {$year}",
                    'revenue' => $orders->sum('total_amount'),
                    'sort_key' => $key,
                ];
            })
            ->sortByDesc('sort_key')
            ->values()
            ->map(function ($entry) {
                return (object) [
                    'quarter' => $entry->quarter,
                    'revenue' => $entry->revenue,
                ];
            });

        $orderItems = OrderItem::with('product.category')
            ->whereHas('order', function ($query) {
                $query->where('status', 'paid');
            })
            ->get();

        $salesByCategory = $orderItems
            ->groupBy(function ($item) {
                return $item->product?->category?->name ?? 'Sans catégorie';
            })
            ->map(function ($items, $categoryName) {
                return (object) [
                    'name' => $categoryName,
                    'revenue' => $items->sum(fn ($item) => $item->price * $item->quantity),
                ];
            })
            ->sortByDesc('revenue')
            ->values()
            ->take(5);

        $topProducts = $orderItems
            ->groupBy(function ($item) {
                return $item->product?->title ?? 'Produit inconnu';
            })
            ->map(function ($items, $productTitle) {
                return (object) [
                    'title' => $productTitle,
                    'revenue' => $items->sum(fn ($item) => $item->price * $item->quantity),
                    'units' => $items->sum('quantity'),
                ];
            })
            ->sortByDesc('revenue')
            ->values()
            ->take(5);

        return view('admin.dashboard.index', compact(
            'totalSales',
            'totalOrders',
            'paidOrders',
            'salesByQuarter',
            'salesByCategory',
            'topProducts'
        ));
    }
}
