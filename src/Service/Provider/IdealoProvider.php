<?php

declare(strict_types=1);

namespace App\Service\Provider;

use App\Entity\ProductSource;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class IdealoProvider implements ProviderInterface
{
    public const UID = 'idealo';

    /**
     * @inheritDoc
     */
    public function uid(): string
    {
        return self::UID;
    }

    /**
     * @inheritDoc
     *
     * @throws ClientExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws ServerExceptionInterface
     * @throws TransportExceptionInterface
     * @throws \Exception
     */
    public function getPrice(ProductSource $productSource): string
    {
        $price = '0';

        $client = HttpClient::create();
        $response = $client->request('GET', $productSource->getSource());
        $content = $response->toArray();

        $now = new \DateTimeImmutable();

        foreach ($content['data'] as $value) {
            $date = new \DateTimeImmutable($value['x']);
            $interval = $date->diff($now);

            if ($interval->d !== 0) {
                continue;
            }

            $price = strval($value['y']);

            break;
        }

        return $price;
    }
}
