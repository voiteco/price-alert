<?php

declare(strict_types=1);

namespace App\Service\Notification;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class TelegramSender implements SenderInterface
{
    private const URL = 'https://api.telegram.org/bot%s/sendMessage';

    /**
     * @var array
     */
    private $config;

    /**
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * @inheritDoc
     *
     * @throws TransportExceptionInterface
     */
    public function send(string $message): void
    {
        $url = sprintf(self::URL, $this->config['token']);
        $request = [
            'chat_id' => $this->config['chat'],
            'text' => $message,
            'parse_mode' => 'Markdown',
            'disable_web_page_preview' => false,
        ];

        $client = HttpClient::create();
        $client->request('POST', $url, [
            'body' => $request,
        ]);
    }
}
