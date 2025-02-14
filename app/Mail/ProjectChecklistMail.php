<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProjectChecklistMail extends Mailable
{
    use Queueable, SerializesModels;

    public $record;
    public $pdf;

    public function __construct($record, $pdf)
    {
        $this->record = $record;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Checklist del Proyecto: ' . $this->record->name)
            ->view('emails.project_checklist')
            ->attachData($this->pdf, 'Checklist_' . str_replace(' ', '_', $this->record->name) . '.pdf', [
                'mime' => 'application/pdf',
            ]);
    }
}
