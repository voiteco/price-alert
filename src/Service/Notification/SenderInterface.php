<?php

declare(strict_types=1);

namespace App\Service\Notification;

interface SenderInterface
{
    /**
     * @param string $message
     */
    public function send(string $message): void;
}
