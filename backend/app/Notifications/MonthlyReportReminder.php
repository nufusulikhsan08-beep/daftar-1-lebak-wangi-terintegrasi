<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MonthlyReportReminder extends Notification implements ShouldQueue
{
    use Queueable;

    protected $daysRemaining;

    /**
     * Create a new notification instance.
     */
    public function __construct($daysRemaining)
    {
        $this->daysRemaining = $daysRemaining;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $message = $this->daysRemaining > 0 
            ? "Sisa {$this->daysRemaining} hari lagi untuk mengirim laporan bulanan."
            : "Laporan bulanan sudah melewati batas waktu pengiriman.";
        
        $urgency = $this->daysRemaining <= 3 ? 'warning' : 'info';
        
        return (new MailMessage)
                    ->subject('🔔 Pengingat Laporan Daftar 1 Bulanan')
                    ->greeting('Halo, ' . $notifiable->name)
                    ->line('Ini adalah pengingat untuk mengirim laporan Daftar 1 bulanan.')
                    ->line($message)
                    ->action('Kirim Laporan Sekarang', url('/dashboard'))
                    ->line('Terima kasih telah menggunakan sistem Daftar 1 Digital.')
                    ->salutation('Salam, Tim Dinas Pendidikan Lebak Wangi');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'monthly_report_reminder',
            'message' => "Pengingat: Laporan bulanan harus dikirim. Sisa {$this->daysRemaining} hari.",
            'days_remaining' => $this->daysRemaining,
            'url' => '/dashboard',
        ];
    }
}