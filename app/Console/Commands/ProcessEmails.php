<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Webklex\IMAP\Facades\Client;
use App\Models\Task;

class ProcessEmails extends Command
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
                Task::create([
                    'name' => $message->getSubject(),
                    'priority' => 1, // Default priority, можно настроить в зависимости от ваших требований.
                ]);

                // Пометить письмо как прочитанное или переместить в другую папку, если необходимо.
                $message->setFlag(['Seen']);
            }

            $client->disconnect();
        }
    }
