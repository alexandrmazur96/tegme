Telegraph me.
---

Tegme is lightweight client for telegra.ph/api.

## Installation

`$ composer require tegme/tegme`

## Usage

```$php
<?php

use Tegme\TelegramPusher;

$telegramApiKey = 'telegram_api_key';

$pusher = new TelegramPusher($telegramApiKey);

try {
    $response = $pusher->call('SendMessage', [
        'chat_id' => '@testchat',
        'text' => '*Example* text',
        'parse_mode' => 'Markdown',
    ]);
} catch (Telme\Exceptions\CurlException | Telme\Exceptions\TelegramBotApiException $e) {
    echo $e->getMessage(), PHP_EOL;
}

/**
Example response structure:

[
    'ok' => true,
    'result' => [
        'message_id' => 84,
        'chat' => [
            'id' => -1001410394173,
            'title' => 'test_channel',
            'username' => 'testchannel',
            'type' => 'channel',
        ],
        'date' => 1571236539,
        'text' => 'Test message',
        'entities' => [
            [
                'offset' => 0,
                'length' => 4,
                'type' => 'bold',
            ],
        ],
    ],
]
*/

echo $response['result']['text'], PHP_EOL;
```

List of available action and parameters you can find [here](https://core.telegram.org/bots/api#available-methods).

### Author

Mazur Alexandr - alexandrmazur96@gmail.com - https://t.me/alexandrmazur96

### License

Telme is licensed under the GNU General Public License - see the LICENSE file for details.