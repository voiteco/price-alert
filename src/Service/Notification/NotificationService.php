<?php

declare(strict_types=1);

namespace App\Service\Notification;

use App\Service\Template\TemplateService;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ServiceLocator;

class NotificationService
{
    public const PRICE_ALERT_ACTION = 'price_alert';

    /**
     * @var string
     */
    private $sender;

    /**
     * @var ServiceLocator
     */
    private $senderLocator;

    /**
     * @var TemplateService
     */
    private $templateService;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param string          $sender
     * @param ServiceLocator  $senderLocator
     * @param TemplateService $templateService
     * @param LoggerInterface $logger
     */
    public function __construct(
        string $sender,
        ServiceLocator $senderLocator,
        TemplateService $templateService,
        LoggerInterface $logger
    ) {
        $this->sender = $sender;
        $this->senderLocator = $senderLocator;
        $this->templateService = $templateService;
        $this->logger = $logger;
    }

    /**
     * @param string $action
     * @param array  $data
     */
    public function send(string $action, array $data): void
    {
        $message = $this->templateService->process($action, $data);

        /** @var SenderInterface $notificationSender */
        $notificationSender = $this->senderLocator->get($this->sender);

        try {
            $notificationSender->send($message);
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }
}
