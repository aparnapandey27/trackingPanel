<?php

namespace App\Console\Commands;

use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;

class Invoice extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invoice {--weekly} {--monthly}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate new student invoice';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('weekly')) {
            $this->generateInvoice('weekly');
            $this->info('Weekly invoice generated');
        } else {
            $this->generateInvoice('monthly');
            $this->info('Monthly invoice generated');
        }
    }


    /**
     * Generate invoice
     *
     * @return void
     *
     */
    protected function generateInvoice($payment_frequency)
    {
        $users = \App\Models\User::student()->active()->where('payment_frequency', $payment_frequency)->get();

        /*
        * get last day of last month for generating monthly invoice
        */
        $carbon = new Carbon('last day of last month');
        $monthly = $carbon->endOfMonth()->toDateString();

        /*
        * get last day of last week for generating weekly invoice
        */
        $weekly = Carbon::now()->subDays(7)->endOfWeek()->toDateString();

        /*
        * date setup as payment frequency
        */
        $date = $payment_frequency == 'weekly' ? $weekly : $monthly;

        foreach ($users as $user) {
            /* Checking If any payable Conversion available for the user*/
            $amount = \App\Models\Conversion::where([['student_id', '=', $user->id], ['status', '=', 'approved'], ['paid', '=', 0],])->whereDate('created_at', '<=', $date)->sum('payout');

            if ($amount > 0 && $user->payment_method != null) {
                /* Checking If the user has any pending invoice*/
                $forwarded_balance = Payment::where([['student_id', '=', $user->id], ['status', '=', 0],])->sum('payable_amount');
                $forwarded_invoices = Payment::where([['student_id', '=', $user->id], ['status', '=', 0],])->get();
                foreach ($forwarded_invoices as $forwarded_invoice) {
                    $forwarded_invoice = Payment::find($forwarded_invoice->id);
                    $forwarded_invoice->status = 4;
                    $forwarded_invoice->save();
                }

                /* Unpaid conversion must be paid first */
                $conversions = \App\Models\Conversion::where([['student_id', '=', $user->id], ['status', '=', 'approved'], ['paid', '=', 0],])->get();
                foreach ($conversions as $conversion) {
                    $conversion = \App\Models\Conversion::find($conversion->id);
                    $conversion->paid = 1;
                    $conversion->save();
                }


                /* Generate new invoice */
                $invoice = new Payment();
                $invoice->student_id = $user->id;
                $invoice->amount = $amount + $forwarded_balance;
                $invoice->payable_amount = $amount + $forwarded_balance;
                $invoice->currency = config('app.currency');
                $invoice->payment_method = $user->payment_method != null ? $user->payment_method->payment_option->name : 'Unknown';
                $invoice->payment_frequency = $payment_frequency;
                $invoice->payment_method_detail = $user->payment_method != null ? $user->payment_method->details : 'Unknown';;
                $invoice->save();
            }
        }
    }
}
