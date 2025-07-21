<?php

namespace App\Http\Controllers;

use App\Jobs\GenerateDailyWorkReport;
use App\Models\CacheWorksReport;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class CacheWorksReportController extends Controller
{
    //
    // public function generateDailyReport(Request $request)
    // {
    //     $startDate = $request->query('start_date'); // ممكن تكون null
    //     $endDate = $request->query('end_date');     // ممكن تكون null

    //     GenerateDailyWorkReport::dispatch($startDate, $endDate);

    //     return response()->json([
    //         'message' => '✅ تم إرسال الجوب بنجاح',
    //         'start_date' => $startDate,
    //         'end_date' => $endDate,
    //     ]);
    // }
    public function generateDailyReport(Request $request)
    {
        $startDate = $request->query('start_date'); // ممكن تكون null
        $endDate = $request->query('end_date');     // ممكن تكون null

        GenerateDailyWorkReport::dispatch( $startDate, $endDate);

        return response()->json([
            'message' => '✅ تم إرسال الجوب بنجاح',
            'start_date' => $startDate,
            'end_date' => $endDate,
        ]);
    }

    /**
     * عرض التقرير بناءً على تاريخ أو فترة
     */
    public function showReports(Request $request)
    {

        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        if ($startDate && $endDate) {
            $reports = CacheWorksReport::whereBetween('date', [
                Carbon::parse($startDate)->toDateString(),
                Carbon::parse($endDate)->toDateString()
            ])->orderBy('date')->get();

            return response()->json([
                'message' => '✅ تم جلب التقارير للفترة المحددة',
                'start_date' => $startDate,
                'end_date' => $endDate,
                'reports' => $reports
            ]);
        }

        // ✅ إذا لم يتم تمرير أي شيء: رجّع آخر 7 تقارير
        $reports = CacheWorksReport::orderByDesc('date')->take(7)->get()->reverse();

        return response()->json([
            'message' => '✅ آخر 7 تقارير',
            'reports' => $reports
        ]);
    }
}
