<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectStatusChangeNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;
    protected $status;
    protected $message;

    public function __construct($project, $status, $message)
    {
        $this->project = $project;
        $this->status = $status;
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->greeting('Bonjour ' . $notifiable->nom_user)
                    ->line($this->message)
                    ->line('Merci pour votre contribution !');
    }

    public function toArray($notifiable)
    {
        $message = '';

        if ($this->status === 'Approved') {
            $message = 'Bonjour ' . $notifiable->nom_user . ', votre projet "' . $this->project->titre_projet . '" a été approuvé par AcadProManage. Nous vous remercions pour votre contribution.';
        } elseif ($this->status === 'Rejected') {
            $message = 'Bonjour ' . $notifiable->nom_user . ', votre projet "' . $this->project->titre_projet . '" n\'a pas été approuvé par AcadProManage. Nous vous remercions pour votre soumission et vous encourageons à soumettre à nouveau après les modifications nécessaires.';
        }else{
            $message = 'Bonjour ' . $notifiable->nom_user . ', votre projet "' . $this->project->titre_projet . '" a ete restaurer et mis en etat d attente pour une nouvelle evaluation. Nous vous tiendrons informer de la decision finale ';
        }

        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->titre_projet,
            'status' => $this->status,
            'message' => $message
        ];
    }
}

