<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use Webklex\PHPIMAP\Support\MessageCollection;
use App\Models\Task;

class FetchEmails extends Command
{
    protected $signature = 'emails:process';
    protected $description = 'Process incoming emails and create tasks';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $client = Client::account('default');
        $client->connect();

        /* @var MessageCollection $messages */
        $messages = $client->getFolder('INBOX')->messages()->unseen()->get();

        foreach ($messages as $message) {
            $subject = $message->getSubject();
            if (empty($subject)) {
                $subject = 'No Subject';
            } else {
                $subject = $this->decodeMimeStr($subject);
            }
            $task = new Task();
            $task->subject = $subject;
            $task->priority = 1; // Default priority, можно настроить в зависимости от ваших требований.
            // Убедитесь, что отправитель всегда доступен
            $sender = $message->getFrom();
            if (!empty($sender)) {
                $task->sender = $sender[0]->mail;
            } else {
                $task->sender = 'Unknown Sender';
            }

            // Преобразуем getCc() в массив
            $ccRecipients = $message->getCc();
            $ccRecipientsArray = [];
            foreach ($ccRecipients as $recipient) {
                $ccRecipientsArray[] = $recipient->mail;
            }
            $task->recipients = json_encode($ccRecipientsArray);

            $task->body = $message->getHTMLBody();

            // Преобразуем getAttachments() в массив
            $attachments = $message->getAttachments();
            $attachmentsArray = [];
            foreach ($attachments as $attachment) {
                $attachmentsArray[] = $attachment->getName();
            }
            $task->attachments = json_encode($attachmentsArray);

            $task->save();

            // Пометить письмо как прочитанное и переместить в другую папку
            $message->setFlag(['Seen']);
            $message->moveToFolder('Processed');
        }

        $client->disconnect();
    }

    /*
     * Decode MIME string.
     *
     * @param string $string
     * @return string
     */
    private function decodeMimeStr($string)
    {
        $elements = imap_mime_header_decode($string);
        $decoded = '';

        foreach ($elements as $element) {
            $decoded .= $element->text;
        }

        return $decoded;
    }
}