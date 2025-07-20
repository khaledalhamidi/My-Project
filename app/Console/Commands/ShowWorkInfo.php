<?php

namespace App\Console\Commands;

use App\Models\work;
use Illuminate\Console\Command;

class ShowWorkInfo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:show-work-info {id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //

        $id = $this->argument('id'); //accept input from terminal
        $work = work::find($id);

        if ($work) {
            $this->info("Work found with ID: {$work->id}");
            $this->info("Title: {$work->title}");
            $this->info("status   {$work->status}");
        } else {
            $this->error(" Work not found with ID: {$id}");
        }
    }
}
