<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable as QueueQueueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GenerateCouponReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, QueueQueueable, SerializesModels;

    public function __construct()
    {
        //
    }

    public function handle(): void
    {
        try {
            Log::info('🔄 Job Started: GenerateCouponReport');

            $orders = DB::table('salla_orders')
                ->select('id', 'created_at', 'coupon_code', 'amounts')
                ->whereNotNull('coupon_code')
                ->get();

            $rows = [];

            foreach ($orders as $order) {
                $amounts = json_decode($order->amounts, true);

                $sub = $amounts['sub_total']['amount'] ?? 0;
                $tot = $amounts['total']['amount'] ?? 0;

                $discount = $sub - $tot;
                $percent = $sub ? round(($discount / $sub) * 100, 2) : 0;

                $rows[] = [
                    'order_id' => $order->id,
                    'order_date' => $order->created_at,
                    'coupon_code' => $order->coupon_code,
                    'sub_total' => $sub,
                    'total' => $tot,
                    'discount_amount' => $discount,
                    'discount_percentage' => $percent,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }


            DB::table('coupon_cash_report')->delete();
            DB::table('coupon_cash_report')->insert($rows);

            Log::info('✅ Job Finished: GenerateCouponReport');
        } catch (\Exception $e) {
            Log::error('❌ Job Failed: ' . $e->getMessage());
        }
    }
}
