<?php
namespace App\Entity;

use App\Entity\ProductSystem;
use App\Entity\ProductSystemAttribute;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_attribute")
 *
 * Defines the intermediate table to store the attribute values of the products.
 *
 */
class ProductAttribute
{

	/**
   * @var int
   *
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\ManyToOne(targetEntity="ProductSystem", inversedBy="productAttributes")
   * @ORM\JoinColumn(name="prod_id", referencedColumnName="id", nullable=true)
   */
  private $product;

  /**
   * @ORM\ManyToOne(targetEntity="ProductSystemAttribute", inversedBy="products")
   * @ORM\JoinColumn(name="attr_id", referencedColumnName="id", nullable=true)
   */
  private $attribute;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $value;

  /**
   * @var \DateTime
   *
   * @ORM\Column(type="datetime")
   * @Assert\Type("\DateTimeInterface")
   */
  private $createTime;

  /**
   * @var \DateTime
   *
   * @ORM\Column(type="datetime")
   * @Assert\Type("\DateTimeInterface")
   */
  private $lastUpdate;


  public function __construct()
  {
      $this->createTime = new \DateTime();
  }


  public function getId(): ?string {
    return $this->id;
  }

  public function setProduct(ProductSystem $product): void {
    $this->product = $product;
  }

  public function getProduct(): array {
    return $this->product;
  }

  public function setAttribute(ProductSystemAttribute $attribute): void {
    $this->attribute = $attribute;
  }

  public function getAttribute(): array {
    return $this->attribute;
  }

  public function setValue(?string $value): void {
    $this->value = $value;
  }

  public function getValue(): ?string {
    return $this->value;
  }

  public function getCreateTime()
  {
    return $this->createTime;
  }

  public function setCreateTime($createTime)
  {
    $this->createTime = $createTime;
  }

  public function getLastUpdate()
  {
    return $this->lastUpdate;
  }

  public function setLastUpdate($lastUpdate)
  {
    $this->lastUpdate = $lastUpdate;
  } 
  
}