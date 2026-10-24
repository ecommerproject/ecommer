<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminReportController extends Controller
{
    public function index(Request $request): View
    {
        $type = $request->query('type', 'sales');
        $range = $request->query('range', 'this_month');

        $now = now();
        $startDate = match ($range) {
            'today' => $now->copy()->startOfDay(),
            'last_7_days' => $now->copy()->subDays(6)->startOfDay(),
            'last_month' => $now->copy()->subMonth()->startOfMonth(),
            'all_time' => Carbon::createFromTimestamp(0),
            default => $now->copy()->startOfMonth(),
        };

        // Summary Statistics for the Reports Overview
        $totalOrders = Order::where('created_at', '>=', $startDate)->count();
        $totalRevenue = (float) Order::where('created_at', '>=', $startDate)->where('payment_status', 'paid')->sum('total_amount');
        $totalProducts = Product::count();
        $totalStockUnits = (int) Product::all()->sum(fn ($p) => (int) ($p->stock ?? 45));
        $totalValuation = (float) Product::all()->sum(fn ($p) => ((float) $p->price) * ((int) ($p->stock ?? 45)));
        $totalCustomers = User::where('is_admin', false)->count();

        // Data collection depending on active tab
        $reportData = match ($type) {
            'inventory' => Product::orderBy('category')->orderBy('id')->get(),
            'orders' => Order::where('created_at', '>=', $startDate)->orderByDesc('id')->get(),
            'customers' => User::where('is_admin', false)->orderByDesc('id')->get(),
            default => Order::where('created_at', '>=', $startDate)->where('payment_status', 'paid')->orderByDesc('id')->get(),
        };

        return view('admin.reports.index', [
            'type' => $type,
            'range' => $range,
            'reportData' => $reportData,
            'kpis' => [
                'total_revenue' => $totalRevenue,
                'total_orders' => $totalOrders,
                'total_products' => $totalProducts,
                'total_stock_units' => $totalStockUnits,
                'total_valuation' => $totalValuation,
                'total_customers' => $totalCustomers,
            ],
        ]);
    }

    public function exportSales(): StreamedResponse
    {
        $filename = 'dara-market-sales-report-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                throw new \RuntimeException('Unable to open CSV output stream.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Dara Market - Sales & Revenue Report']);
            fputcsv($output, ['Exported At', now()->toDateTimeString()]);
            fputcsv($output, []);
            fputcsv($output, ['Order Number', 'Customer Name', 'Customer Email', 'City/Province', 'Total Amount ($)', 'Payment Method', 'Payment Status', 'Order Status', 'Date']);

            Order::query()->orderByDesc('id')->chunk(200, function ($orders) use ($output): void {
                foreach ($orders as $order) {
                    fputcsv($output, [
                        $order->order_number,
                        $this->safeCsvCell($order->customer_name),
                        $this->safeCsvCell($order->customer_email),
                        $this->safeCsvCell($order->shipping_city ?? 'Phnom Penh'),
                        $order->total_amount,
                        $order->payment_method,
                        $order->payment_status,
                        $order->order_status,
                        $order->created_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportInventory(): StreamedResponse
    {
        $filename = 'dara-market-inventory-report-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                throw new \RuntimeException('Unable to open CSV output stream.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Dara Market - Product Inventory Valuation Report']);
            fputcsv($output, ['Exported At', now()->toDateTimeString()]);
            fputcsv($output, []);
            fputcsv($output, ['SKU Code', 'Product Name (EN)', 'Product Name (KM)', 'Category', 'Unit Price ($)', 'Current Stock', 'Stock Status', 'Total Stock Valuation ($)']);

            Product::query()->orderBy('category')->orderBy('id')->chunk(200, function ($products) use ($output): void {
                foreach ($products as $product) {
                    $stock = $product->stock ?? 45;
                    $val = ((float) $product->price) * $stock;
                    fputcsv($output, [
                        $product->sku,
                        $this->safeCsvCell($product->name_en),
                        $this->safeCsvCell($product->name_km),
                        $product->category,
                        $product->price,
                        $stock,
                        $product->stock_status,
                        number_format($val, 2, '.', ''),
                    ]);
                }
            });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    public function exportOrders(): StreamedResponse
    {
        return $this->exportSales();
    }

    public function exportCustomers(): StreamedResponse
    {
        $filename = 'dara-market-customers-report-'.now()->format('Y-m-d').'.csv';

        return response()->streamDownload(function (): void {
            $output = fopen('php://output', 'w');
            if ($output === false) {
                throw new \RuntimeException('Unable to open CSV output stream.');
            }

            fwrite($output, "\xEF\xBB\xBF");
            fputcsv($output, ['Dara Market - Customers & CRM Audit Report']);
            fputcsv($output, ['Exported At', now()->toDateTimeString()]);
            fputcsv($output, []);
            fputcsv($output, ['ID', 'Customer Name', 'Email', 'Role', 'Email Verified', 'Registered At']);

            User::query()->orderByDesc('id')->chunk(200, function ($users) use ($output): void {
                foreach ($users as $user) {
                    fputcsv($output, [
                        $user->id,
                        $this->safeCsvCell($user->name),
                        $this->safeCsvCell($user->email),
                        $user->is_admin ? 'Admin' : 'Customer',
                        $user->email_verified_at ? 'Verified' : 'Unverified',
                        $user->created_at?->toDateTimeString(),
                    ]);
                }
            });

            fclose($output);
        }, $filename, ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    private function safeCsvCell(string $value): string
    {
        return preg_match('/^[=+\-@\t\r]/', $value) === 1 ? "'".$value : $value;
    }
}
