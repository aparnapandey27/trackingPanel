<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DailyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reportPath;

    public function __construct($reportPath)
    {
        $this->reportPath = $reportPath;
    }

    public function build()
    {
        return $this->view('mail.daily_report')
            ->subject('Daily Report') // Add your subject here
            ->attach($this->reportPath, [
                'as' => 'daily_report.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
    }
}
