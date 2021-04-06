<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\ProductSystemInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="product_system")
 *
 * Defines the properties of the Product System entity.
 *
 */
class ProductSystem
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
   * @ORM\OneToMany(targetEntity="ProductAttribute", mappedBy="product")
   */
  private $productAttributes;
  /**
   * @var string
   *
   * @ORM\Column(type="string")
   * @Assert\NotBlank()
   */
  private $sku;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $ean13;

  /**
   * @var array
   *
   * @ORM\Column(type="array", nullable=true)
   */
  private $eans;

	/**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $description;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $name;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $intrastat;

	/**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $brandName;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $categoryName;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $categoryName2;

  /**
   * @var string
   *
   * @ORM\Column(type="string", nullable=true)
   */
  private $categoryName3;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $pvp;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $priceCatalog;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $assortment;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $stock;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $stockCatalog;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $stockToShow;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $stockAvailable;

  /**
   * @var int
   *
   * @ORM\Column(type="integer", nullable=true)
   */
  private $vmd;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $weight;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $height;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $width;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $length;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $height2;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $width2;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $length2;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $weightPackaging;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $heightPackaging;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $widthPackaging;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $lengthPackaging;

  /**
   * @var float
   *
   * @ORM\Column(type="float", nullable=true)
   */
  private $cbm;

  /**
   * @var boolean
   *
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $new;

  /**
   * @var boolean
   *
   * @ORM\Column(type="boolean", nullable=true)
   */
  private $active;

  /**
   * @var array
   *
   * @ORM\Column(type="array", nullable=true)
   */
  private $productImages;


  public function getId(): ?string {
    return $this->id;
  }

  public function setProductAttributes(array $productAttributes): void {
    $this->productAttributes = $productAttributes;
  }

  public function getProductAttributes(): array {
    return $this->productAttributes;
  }

  public function setSku(string $sku): void {
    $this->sku = $sku;
  }

  public function getSku(): ?string {
    return $this->sku;
  }

  public function setEan13(?string $ean13): void {
    $this->ean13 = $ean13;
  }

  public function getEan13(): ?string {
    return $this->ean13;
  }

  public function setProductEans(array $eans): void {
    $this->eans = $eans;
  }

  public function getProductEans(): array {
    return $this->eans;
  }

  public function setName(?string $name): void {
    $this->name = $name;
  }

  public function getName(): ?string {
    return $this->name;
  }

  public function setBrandName(?string $brandName): void {
    $this->brandName = $brandName;
  }

  public function getBrandName(): ?string {
    return $this->brandName;
  }

  public function setDescription(?string $description): void {
    $this->description = $description;
  }

  public function getDescription(): ?string {
    return $this->description;
  }

  public function setInstrastat($intrastat): void {
    $this->intrastat = $intrastat;
  }

  public function getInstrastat(): ?string {
    return $this->intrastat;
  }

  public function setCategoryName(?string $categoryName): void {
    $this->categoryName = $categoryName;
  }

  public function getCategoryName(): ?string {
    return $this->categoryName;
  }

  public function setCategoryName2($categoryName2): void  {
  	$this->categoryName2 = $categoryName2;
  }

  public function getCategoryName2(): ?string {
  	return $this->categoryName2;
  }

  public function setCategoryName3($categoryName3): void  {
  	$this->categoryName3 = $categoryName3;
  }

  public function getCategoryName3(): ?string {
  	return $this->categoryName3;
  }

  public function setPvp(float $pvp): void {
    $this->pvp = $pvp;
  }

  public function getPvp(): float {
    return $this->pvp;
  }

  public function setPriceCatalog(float $priceCatalog): void {
    $this->priceCatalog = $priceCatalog;
  }

  public function getPriceCatalog(): ?float {
    return $this->priceCatalog;
  }

  public function setAssortment(int $assortment): void {
    $this->assortment = $assortment;
  }

  public function getAssortment(): int {
    return $this->assortment;
  }

  public function setStock(int $stock): void {
    $this->stock = $stock;
  }

  public function getStock(): ?int {
    return $this->stock;
  }

  public function setStockCatalog(int $stockCatalog): void {
    $this->stockCatalog = $stockCatalog;
  }

  public function getStockCatalog(): ?int {
    return $this->stockCatalog;
  }

  public function setStockToShow(int $stockToShow): void {
    $this->stockToShow = $stockToShow;
  }

  public function getStockToShow(): int {
    return $this->stockToShow;
  }

  public function setStockAvailable(int $stockAvailable): void {
    $this->stockAvailable = $stockAvailable;
  }

  public function getStockAvailable(): int {
    return $this->stockAvailable;
  }

  public function setVmd(int $vmd): void {
    $this->vmd = $vmd;
  }

  public function getVmd(): int {
    return $this->vmd;
  }

  public function setWeight($weight): void {
    $this->weight = $weight;
  }

  public function getWeight(): ?float {
    return $this->weight;
  }

  public function setLength($length): void {
    $this->length = $length;
  }

  public function getLength(): ?float {
    return $this->length;
  }

  public function setHeight($height): void {
    $this->height = $height;
  }

  public function getHeight(): ?float {
    return $this->height;
  }

  public function setWidth($width): void {
    $this->width = $width;
  }

  public function getWidth(): ?float {
    return $this->width;
  }

  public function setLength2($length2): void {
    $this->length2 = $length2;
  }

  public function getLength2(): ?float {
    return $this->length2;
  }

  public function setHeight2($height2): void {
    $this->height2 = $height2;
  }

  public function getHeight2(): ?float {
    return $this->height2;
  }

  public function setWidth2($width2): void {
    $this->width2 = $width2;
  }

  public function getWidth2(): ?float {
    return $this->width2;
  }

  public function setWeightPackaging($weightPackaging): void {
    $this->weightPackaging = $weightPackaging;
  }

  public function getWeightPackaging(): ?float {
    return $this->weightPackaging;
  }

  public function setLengthPackaging($lengthPackaging): void {
    $this->lengthPackaging = $lengthPackaging;
  }

  public function getLengthPackaging(): ?float {
    return $this->lengthPackaging;
  }

  public function setHeightPackaging($heightPackaging): void {
    $this->heightPackaging = $heightPackaging;
  }

  public function getHeightPackaging(): ?float {
    return $this->heightPackaging;
  }

  public function setWidthPackaging($widthPackaging): void {
    $this->widthPackaging = $widthPackaging;
  }

  public function getWidthPackaging(): ?float {
    return $this->widthPackaging;
  }

  public function setCbm($cbm): void {
    $this->cbm = $cbm;
  }

  public function getCbm(): ?float {
    return $this->cbm;
  }

  public function setNew($new): void {
    $this->new = $new;
  }

  public function getNew(): ?int {
    return $this->new;
  }

  public function setActive($active): void {
    $this->active = $active;
  }

  public function getActive(): ?int {
    return $this->active;
  }

  public function setProductImages(array $productImages): void {
    $this->productImages = $productImages;
  }

  public function getProductImages(): array {
    return $this->productImages;
  }

}