<?php

namespace App\Http\Controllers;

use App\Models\ProductMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ProductReportController extends Controller
{
    //
    public function productMovements(Request $request)
    {

        $q = ProductMovement::query()
            ->with([
                'user:id,name',
                'product:id,name,sku'
            ])
            ->when(
                $request->filled('employee_name'),
                fn($qb) =>
                $qb->whereHas(
                    'user',
                    fn($u) =>
                    $u->where('name', 'LIKE', '%' . $request->employee_name . '%')
                )
            )
            ->when(
                $request->filled('sku'),
                fn($qb) =>
                $qb->whereHas(
                    'product',
                    fn($p) =>
                    $p->where('sku', '=', $request->sku)
                )
            )
            ->when(
                $request->filled(['from', 'to']),
                fn($qb) =>
                $qb->whereBetween('created_at', [
                    Carbon::parse($request->from)->startOfDay(),
                    Carbon::parse($request->to)->endOfDay(),
                ])
            )
            ->latest();

        $totalAdded     = (clone $q)->where('type', 'add')->sum('quantity');
        $totalWithdrawn = (clone $q)->where('type', 'withdraw')->sum('quantity');
        $stats = [
            'total_movements' => $q->count(),
            'unique_products' => $q->distinct('product_id')->count(),
            'total_added'      => $totalAdded,
            'total_withdrawn'  => $totalWithdrawn,
            'net_change'       => (int)$totalAdded - (int)$totalWithdrawn,
        ];

        $perPage = $request->query('per_page', 25);
        $movements = $q->paginate((int)$perPage);

        return response()->json([
            'stats' => $stats,
            'data' => $movements
        ]);
    }
}
