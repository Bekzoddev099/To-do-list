<?php

declare(strict_types=1);

require 'vendor/autoload.php';
require 'Bot.php';

use GuzzleHttp\Client;

$token = '7252436054:AAHeM8UKS-1jf03zavA0xcFfyF0gOtAG7PU';
$tgApi = "https://api.telegram.org/bot$token/";

$client = new Client(['base_uri' => $tgApi]);
$bot = new Bot($client);

$update = json_decode(file_get_contents('php://input'), true);

if ($update) {
    $bot->handleUpdate($update);
}
?>
