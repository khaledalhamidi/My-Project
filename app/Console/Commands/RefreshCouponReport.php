<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class RefreshCouponReport extends Command
{
    protected $signature = 'report:refresh';
    protected $description = 'تحديث تقرير الخصومات';

    public function handle()
    {
        $orders = DB::table('salla_orders')
            ->whereNotNull('coupon_code')
            ->get(['id', 'created_at', 'coupon_code', 'amounts']);

        $rows = [];

        foreach ($orders as $order) {
            // فك JSON مباشرة (إذا لزم، أضف دالة decodeUnicode هنا)
            $data = json_decode($order->amounts, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->error("JSON error on order {$order->id}: " . json_last_error_msg());
                continue;
            }

            $sub = $data['sub_total']['amount'] ?? 0;
            $tot = $data['total']['amount'] ?? 0;
            $discAmt = $sub - $tot;
            $discPct = $sub ? round(($discAmt / $sub) * 100, 2) : 0;

            $rows[] = [
                'order_id'            => $order->id,
                'order_date'          => $order->created_at,
                'coupon_code'         => $order->coupon_code,
                'sub_total'           => $sub,
                'total'               => $tot,
                'discount_amount'     => $discAmt,
                'discount_percentage' => $discPct,
                'created_at'          => now(),
                'updated_at'          => now(),
            ];
        }

        DB::transaction(function () use ($rows) {
            DB::table('coupon_cash_report')->delete(); // ❌ safe for transaction
            DB::table('coupon_cash_report')->insert($rows);
        });

        // إذا كنت بحاجة لإعادة تعيين AUTO_INCREMENT
        DB::statement('ALTER TABLE coupon_cash_report AUTO_INCREMENT = 1');

        $this->info('✅ Operation Done    .');
    }
}
