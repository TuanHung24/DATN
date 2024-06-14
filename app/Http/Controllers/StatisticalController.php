<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetail;
use App\Models\ProductDetail;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StatisticalController extends Controller
{
    public function getList()
    {
        $inVoice = Invoice::where('status', 4)->count();
        $backInvoice = Invoice::where('status', 5)->count();

        $toTal = Invoice::where('status', 4)->sum('total');
        $totalInvoice = number_format($toTal, 0, ',', '.');

        $cusTomer = Customer::count();
        $quantityProduct = ProductDetail::sum('quantity');

        $priceWarehouse = Warehouse::sum('total');
        $totalWarehouse = number_format($priceWarehouse, 0, ',', '.');

        $sellProduct = InvoiceDetail::select('product_id')
            ->selectRaw('SUM(quantity) as totalpd')
            ->groupBy('product_id')
            ->orderByDesc('totalpd')
            ->take(3)
            ->get();

        return view('statistical', compact('inVoice', 'backInvoice', 'totalInvoice', 'sellProduct', 'cusTomer', 'quantityProduct', 'totalWarehouse'));
    }
    public function statisticalMonth(Request $request)
    {
        try {
        $Month = $request->month;
        $Year = $request->year;

        // Chỉ lấy dữ liệu nếu cả hai tham số tháng và năm đều được cung cấp
        if ($Month && $Year) {
            $data = Invoice::join('invoice_detail', 'invoice.id', '=', 'invoice_detail.invoice_id')
                ->whereYear('invoice.created_at', $Year)
                ->whereMonth('invoice.created_at', $Month)
                ->where('invoice.status', 4)
                ->select(
                    DB::raw('DATE(invoice.created_at) as date'),
                    DB::raw('COUNT(DISTINCT invoice.id) as count'),
                    DB::raw('SUM(invoice_detail.into_money) as tongtien'),
                    DB::raw('SUM(invoice_detail.quantity) as soluong')
                )
                ->groupBy(DB::raw('DATE(invoice.created_at)'))
                ->get();
        } else {
            $data = [];
        }

        // Trả về JSON response sau khi kiểm tra request
        return response()->json($data);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['error' => 'Lỗi máy chủ'], 500);
        }
    }

    public function statisticalDay()
    {



        return view('statistical-day');
    }
    public function hdstatisticalDay(Request $request)
    {
        $day = $request->day;
        $month = $request->month;
        $year = $request->year;

        // Helper function to build query with the date filters
        function applyDateFilters($query, $day, $month, $year)
        {
            if ($day) {
                $query->whereDay('date', $day);
            }
            if ($month) {
                $query->whereMonth('date', $month);
            }
            if ($year) {
                $query->whereYear('date', $year);
            }
            return $query;
        }

        $statuses = [
            'cho_xu_ly' => applyDateFilters(Invoice::where('status', Invoice::TRANG_THAI_CHO_XU_LY), $day, $month, $year)->count(),
            'da_duyet' => applyDateFilters(Invoice::where('status', Invoice::TRANG_THAI_DA_DUYET), $day, $month, $year)->count(),
            'dang_giao' => applyDateFilters(Invoice::where('status', Invoice::TRANG_THAI_DANG_GIAO), $day, $month, $year)->count(),
            'hoan_thanh' => applyDateFilters(Invoice::where('status', Invoice::TRANG_THAI_HOAN_THANH), $day, $month, $year)->count(),
            'da_huy' => applyDateFilters(Invoice::where('status', Invoice::TRANG_THAI_DA_HUY), $day, $month, $year)->count(),
        ];

        return response()->json($statuses);
    }
}
