<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
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

        /** @var \Webklex\PHPIMAP\Support\MessageCollection $messages */
        $messages = $client->getFolder('INBOX')->messages()->unseen()->get();

        foreach ($messages as $message) {
            $task = new Task();
            $task->name = $message->getSubject();
            $task->priority = 1; // Default priority, можно настроить в зависимости от ваших требований.
            $task->sender = $message->getFrom()[0]->mail;
            $task->recipients = json_encode(array_map(function ($recipient) {
                return $recipient->mail;
            }, $message->getCc()));
            $task->body = $message->getHTMLBody();
            $task->attachments = json_encode(array_map(function ($attachment) {
                return $attachment->getName();
            }, $message->getAttachments()));
            $task->save();

            // Пометить письмо как прочитанное и переместить в другую папку
            $message->setFlag(['Seen']);
            $message->moveToFolder('Processed');
        }

        $client->disconnect();
    }
}
