<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CriticalInventoryNotification extends Notification
{
    use Queueable;

    public function __construct(public readonly string $medicineName, public readonly int $stock)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage())
            ->subject('Critical medicine stock alert')
            ->line("{$this->medicineName} is at {$this->stock} units.")
            ->action('Open Inventory', url('/portal/pharmacist'));
    }

    public function toArray(object $notifiable): array
    {
        return ['medicine' => $this->medicineName, 'stock' => $this->stock];
    }
}
