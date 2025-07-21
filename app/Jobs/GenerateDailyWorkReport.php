<?php

namespace App\Jobs;

use App\Models\CacheWorksReport;
use App\Models\Work;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Carbon;

class GenerateDailyWorkReport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;



    /**
     * @param string|null $startDate  بداية الفترة (مثلاً '2025-07-01')
     * @param string|null $endDate    نهاية الفترة (مثلاً '2025-07-05')
     */
    public function __construct(protected $startDate = null, protected $endDate = null) {}

    public function handle(): void
    {
        if (!$this->startDate && !$this->endDate) {
            // لو ما حددنا فترة، نعالج يوم واحد (اليوم)

            $this->processDay(Carbon::today());
        } else {
            // لو حددنا فترة، نعالج كل يوم في الفترة

            $start =Carbon::parse( $this->startDate )?? Carbon::today();
            $end =Carbon::parse( $this->endDate) ?? Carbon::today();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $this->processDay($date);
            }
        }
    }

    protected function processDay(Carbon $date): void
    {
        $statuses = ['new', 'in_progress', 'pending', 'completed'];
        $counts = [];

        foreach ($statuses as $status) {
            $counts[$status] = Work::whereDate('created_at', $date->toDateString())
                ->where('status', $status)
                ->count();
        }

        CacheWorksReport::updateOrCreate(
            ['date' => $date->toDateString()],
            [
                'new_count' => $counts['new'] ?? 0,
                'in_progress_count' => $counts['in_progress'] ?? 0,
                'pending_count' => $counts['pending'] ?? 0,
                'completed_count' => $counts['completed'] ?? 0,
            ]
        );
    }
}
