<?php

declare(strict_types=1);

namespace App\Service\Product;

class ProductDto
{
    /**
     * @var string
     */
    private $title;

    /**
     * @var string|null
     */
    private $url;

    /**
     * @var string|null
     */
    private $image;

    /**
     * @var string
     */
    private $oldPrice;

    /**
     * @var string
     */
    private $newPrice;

    /**
     * @var string
     */
    private $diff;

    /**
     * @param string $title
     * @param string|null $url
     * @param string|null $image
     * @param string $oldPrice
     * @param string $newPrice
     * @param string $diff
     */
    public function __construct(
        string $title,
        ?string $url,
        ?string $image,
        string $oldPrice,
        string $newPrice,
        string $diff
    ) {
        $this->title = $title;
        $this->url = $url;
        $this->image = $image;
        $this->oldPrice = $oldPrice;
        $this->newPrice = $newPrice;
        $this->diff = $diff;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string|null
     */
    public function getUrl(): ?string
    {
        return $this->url;
    }

    /**
     * @return string|null
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    /**
     * @return string
     */
    public function getOldPrice(): string
    {
        return $this->oldPrice;
    }

    /**
     * @return string
     */
    public function getNewPrice(): string
    {
        return $this->newPrice;
    }

    /**
     * @return string
     */
    public function getDiff(): string
    {
        return $this->diff;
    }

    /**
     * @return array
     */
    public function asArray(): array
    {
        return [
            'title' => $this->title,
            'url' => $this->url,
            'image' => $this->image,
            'oldPrice' => $this->oldPrice,
            'newPrice' => $this->newPrice,
            'diff' => $this->diff,
        ];
    }
}
