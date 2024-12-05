<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Services\CurrencyRateService;
use App\Mail\DollarRateEmail;
use Mail;

class SendDollarRateJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        \Log::info('Email send job created');
        //
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $this->sendEmail();
        } catch (\Exception $e) {
            \Log::error('Failed to send USDRUB rate email: ' . $e->getMessage());
        }
    }

    /**
     * Send dollar rate email operation.
     *
     * @return void
     */
    private function sendEmail() {
        $dollarRubleRate = app(CurrencyRateService::class)->getDollarRubleRate();

        Mail::to(env('DOLLAR_RATE_EMAIL', 'debug@example.com'))
            ->send(new DollarRateEmail($dollarRubleRate));
    }
}
