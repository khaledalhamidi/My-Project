<?php

namespace App\Http\Controllers;

use App\Http\Resources\CouponReportResources;
use App\Jobs\GenerateCouponReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CouponReportController extends Controller
{
    public function index(Request $request)
    {
        GenerateCouponReport::dispatch();
        // التحقق من صحة المدخلات
        $request->validate([
            'start_date'    => 'nullable|date',
            'end_date'      => 'nullable|date',
            'min_discount'  => 'nullable|numeric',
            'max_discount'  => 'nullable|numeric',
            'per_page'      => 'nullable|integer|min:1|max:100',
        ]);

        // بناء الاستعلام الأساسي
        $query = DB::table('coupon_cash_report')
            ->select('order_id', 'order_date', 'coupon_code', 'sub_total', 'total', 'discount_amount', 'discount_percentage');

        // تطبيق فلترة نطاق التاريخ إذا كانت موجودة
        if ($request->has('start_date') && $request->has('end_date')) {
            $start = Carbon::parse($request->start_date)->startOfDay();
            $end = Carbon::parse($request->end_date)->endOfDay();
            $query->whereBetween('order_date', [$start, $end]);
        }

        // تطبيق فلترة نسبة الخصم إذا كانت موجودة
        if ($request->filled('min_discount') && $request->filled('max_discount')) {
            $query->whereBetween('discount_percentage', [
                $request->min_discount,
                $request->max_discount,
            ]);
        }

        // تحديد عدد العناصر في الصفحة
        $perPage = $request->get('per_page', 50);

        // تنفيذ الاستعلام مع التصفية والصفحات
        $data = $query->orderByDesc('order_date')->paginate($perPage);


        // إرجاع الاستجابة
        return response()->json([
            'data' => $data->items(),
            'pagination' => [
                'current_page'  => $data->currentPage(),
                'per_page'      => $data->perPage(),
                'total'         => $data->total(),
                'last_page'     => $data->lastPage(),
                'next_page_url' => $data->nextPageUrl(),
                'prev_page_url' => $data->previousPageUrl(),
            ],
        ]);
    }
}
