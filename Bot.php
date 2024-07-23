<?php

declare(strict_types=1);

require 'DB.php';

use GuzzleHttp\Client;

class Bot
{
    private $client;
    private $db;
    private $keyboard;

    public function __construct(Client $client)
    {
        $this->client = $client;
        $this->db = new DB();

        $this->keyboard = [
            'keyboard' => [
                [['text' => '➕ Add task'], ['text' => '➖ Delete']],
                [['text' => '✅ Check'], ['text' => '🟩 Uncheck']],
                [['text' => '🗑️ Truncate'], ['text' => '📋 Get task']]
            ],
            'resize_keyboard' => true,
            'one_time_keyboard' => true
        ];
    }

    public function handleUpdate(array $update): void
    {
        if (isset($update['message'])) {
            $message = $update['message'];
            $chat_id = $message['chat']['id'];
            $text = $message['text'];

            switch ($text) {
                case '/start':
                    $this->sendMessage($chat_id, 'Select one of the buttons below');
                    break;
                case '➕ Add task':
                    $this->db->sendText('add');
                    $this->sendMessage($chat_id, 'Please, Enter your task');
                    break;
                case '📋 Get task':
                    $this->sendTasks($chat_id);
                    break;
                case '✅ Check':
                    $this->db->saveCheck('check');
                    $this->sendMessage($chat_id, 'Enter the ID number of the task you want to check');
                    break;
                case '🟩 Uncheck':
                    $this->db->saveUncheck('uncheck');
                    $this->sendMessage($chat_id, 'Enter the ID number of the task you want to uncheck');
                    break;
                case '🗑️ Truncate':
                    $this->db->TruncateTodo();
                    $this->sendMessage($chat_id, 'All tasks have been truncated.');
                    break;
                case '➖ Delete':
                    $this->db->saveDelete('delete');
                    $this->sendMessage($chat_id, 'Enter the ID number of the task you want to delete');
                    break;
                default:
                    $this->handleTextMessage($chat_id, $text);
                    break;
            }
        }
    }

    private function sendMessage(int $chat_id, string $text): void
    {
        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $text,
                'reply_markup' => json_encode($this->keyboard, JSON_UNESCAPED_UNICODE)
            ]
        ]);
    }

    private function sendTasks(int $chat_id): void
    {
        $tasks = $this->db->SendAllUsers();
        $responseText = '';
        $count = 1;

        foreach ($tasks as $task) {
            if ($task['status'] == 1) {
                $responseText .= $count . ': <del>' . $task['todo'] . '</del>' . "\n";
            } else {
                $responseText .= $count . ': ' . $task['todo'] . "\n";
            }
            $count++;
        }

        $this->client->post('sendMessage', [
            'form_params' => [
                'chat_id' => $chat_id,
                'text' => $responseText,
                'parse_mode' => 'HTML'
            ]
        ]);
    }

    private function handleTextMessage(int $chat_id, string $text): void
    {
        $add = $this->db->getText();
        if ($add[0]['add'] === 'add') {
            $this->db->saveTeleText($text);
            $this->db->deleteAddText();
            $this->sendMessage($chat_id, 'Task added successfully!');
            return;
        }

        $check = $this->db->getCheck();
        if ($check[0]['check'] == 'check') {
            $this->db->checkTask((int)$text - 1);
            $this->db->deleteCheck();
            $this->sendMessage($chat_id, 'Task checked successfully!');
            return;
        }

        $uncheck = $this->db->getUncheck();
        if ($uncheck[0]['uncheck'] == 'uncheck') {
            $this->db->uncheckTask((int)$text - 1);
            $this->db->deleteUncheck();
            $this->sendMessage($chat_id, 'Task unchecked successfully!');
            return;
        }

        $delete = $this->db->getDelete();
        if ($delete[0]['delete'] == 'delete') {
            $this->db->deleteTaskUser((int)$text - 1);
            $this->db->deleteTask();
            $this->sendMessage($chat_id, 'Task deleted successfully!');
        }
    }
}
?>
