<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class MoveOldQuotations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotation:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change quotation status to Old after 30 days.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $quotations = Quotation::where('status', 1)->get();

        foreach($quotations as $value){
            $id = $value['id'];
            $created_at = $value['created_at'];
            $date = date('Y-m-d H:i:s');

            $diff = Carbon::now()->diff($created_at)->format('%d');

            if($diff > 30){
                $updateStatus = Quotation::where('id', $id)->update([
                    'status' => 4
                ]);  
            }
        }
    }
}
