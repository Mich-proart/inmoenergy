<?php

namespace App\Console\Commands;

use App\Domain\Enums\FormalityStatusEnum;
use App\Models\Formality;
use App\Models\Status;
use Carbon\Carbon;
use Illuminate\Console\Command;

class AutoCompleteFormality extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:auto-complete-formality';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto complete formality based on the rules, changing the status to finalizado';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $today = Carbon::today();

        $this->info($today);

        $status = Status::where('name', FormalityStatusEnum::FINALIZADO->value)->first();

        Formality::where('contract_completion_date', '<', $today)
            ->whereHas('status', function ($q) {
                $q->whereNotIn('name', [FormalityStatusEnum::FINALIZADO->value, FormalityStatusEnum::BAJA->value]);
            })
            ->update(['status_id' => $status->id]);
    }
}
