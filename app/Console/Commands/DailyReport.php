<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Queue\InteractsWithQueue;

class DailyReport extends Command
{
    use InteractsWithQueue;

    protected $subject = 'Reporte diario: Estado de los registros por pais'; 
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:daily-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reporte diario de los registros de usuario';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $mailer = new Mailer();
        $adminEmail = config('mail.admin');
        $countriesAndTotal = User::select('country')
        ->selectRaw("COUNT('country') AS total")
        ->groupBy('country')
        ->get();
        $mailer->send('emails.admin_report_by_country', compact('countriesAndTotal'), function ($message) use ($adminEmail) {
            $message->to($adminEmail)->subject('Reporte diario: Estado de los registros por pais');
        });
    }
}
