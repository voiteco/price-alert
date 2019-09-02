<?php

declare(strict_types=1);

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductPriceRepository")
 */
class ProductPrice
{
    /**
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     */
    private $product;

    /**
     * @var ProductSource
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\ProductSource")
     */
    private $source;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=14, scale=2)
     */
    private $price;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    /**
     * @param ProductSource $productSource
     * @param string        $price
     *
     * @return ProductPrice
     */
    public static function create(ProductSource $productSource, string $price): self
    {
        $productPrice = new ProductPrice();
        $productPrice->setSource($productSource);
        $productPrice->setProduct($productSource->getProduct());
        $productPrice->setPrice($price);

        return $productPrice;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): void
    {
        $this->product = $product;
    }

    /**
     * @return ProductSource
     */
    public function getSource(): ProductSource
    {
        return $this->source;
    }

    /**
     * @param ProductSource $source
     */
    public function setSource(ProductSource $source): void
    {
        $this->source = $source;
    }

    /**
     * @return string
     */
    public function getPrice(): string
    {
        return $this->price;
    }

    /**
     * @param string $price
     */
    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }
}
