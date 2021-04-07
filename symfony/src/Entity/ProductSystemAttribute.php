<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_system_attribute")
 *
 * Defines the properties of the Product Decoration entity.
 *
 */
class ProductSystemAttribute
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
   * @var ProductAttribute[]|ArrayCollection
   *
   * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="attribute")
   */
  private $products;

  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $name;

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


  public function setProducts(array $products): void {
    $this->products = $products;
  }

  public function getProducts(): array {
    return $this->products;
  }

  public function setName(?string $name): void {
    $this->name = $name;
  }

  public function getName(): ?string {
    return $this->name;
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