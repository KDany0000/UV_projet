<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $project;

    public function __construct($project)
    {
        $this->project = $project;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('Un nouveau projet a été soumis.')
                    ->action('Voir le projet', url('/projects/' . $this->project->id))
                    ->line('Merci de vérifier le projet.');
    }

    public function toArray($notifiable)
    {
        return [
            'project_id' => $this->project->id,
            'project_title' => $this->project->titre_projet,
            'message' => 'Un nouveau projet a été soumis.'
        ];
    }
}

