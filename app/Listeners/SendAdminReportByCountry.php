<?php

namespace App\Listeners;

use App\Events\AdminReportByCountry;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Throwable;

class SendAdminReportByCountry implements ShouldQueue
{
    use InteractsWithQueue;

    protected $mailer;
    /**
     * Create the event listener.
     */
    public function __construct(Mailer $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * Handle the event.
     */
    public function handle(AdminReportByCountry $event): void
    {
        $emailAdmin = config('mail.admin');
        $countriesAndTotal = $event->totalUsersByCountry;
        $this->mailer->send('emails.admin_report_by_country', ['countriesAndTotal' => $countriesAndTotal], function ($message) use ($emailAdmin) {
            $message->to($emailAdmin)->subject('Reporte: Cantidad de usuarios registrados por pais');
        });  
    }
}
