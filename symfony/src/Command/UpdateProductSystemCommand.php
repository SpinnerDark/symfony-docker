<?php

namespace App\Command;

use App\Entity\ProductSystem;
use App\Entity\ProductSystemAttribute;
use App\Entity\ProductAttribute; 
use App\Utils\SimpleXLSX;
use App\Repository\ProductSystemRepository;
use App\Repository\ProductSystemAttributeRepository;
use App\Repository\ProductAttributeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Doctrine\DBAL\DBALException;


class UpdateProductSystemCommand extends Command
{
	// to make your command lazily loaded, configure the $defaultName static property,
    // so it will be instantiated only when the command is actually called.
    protected static $defaultName = 'app:check-products';

    /** @var SymfonyStyle */
    private $io;
    private $client;
    private $entityManager;
    private $productSystem;
    private $productSystemAttribute;
    private $productAttribute;

    public function __construct(HttpClientInterface $client, EntityManagerInterface $em, ProductSystemRepository $productSystem,
      ProductSystemAttributeRepository $productSystemAttribute, ProductAttributeRepository $productAttribute)
    {
      parent::__construct();

      $this->entityManager = $em;
      $this->client = $client;
      $this->productSystem = $productSystem;
      $this->productSystemAttribute = $productSystemAttribute;
      $this->productAttribute = $productAttribute;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure(): void
    {
    	$this
        ->setDescription('Check an URL to save important product information storage')
        ->addArgument('url', InputArgument::REQUIRED, 'The url where the file is stored')
        ->setHelp($this->getCommandHelp());
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
      // SymfonyStyle is an optional feature that Symfony provides so you can
      // apply a consistent look to the commands of your application.
      // See https://symfony.com/doc/current/console/style.html
      $this->io = new SymfonyStyle($input, $output);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
      $executeCode = 0;
      $url = $input->getArgument('url');
      $response = $this->client->request('GET', $url);

      $statusCode = $response->getStatusCode();
      if (200 !== $statusCode) {
        $message = 'URL error. Please check the url';
        $this->io(sprintf('Error: "%s"', $message));
        return Command::FAILURE; 
			}

      $contentType = $response->getHeaders()['content-type'][0];

      switch($contentType)
			{
			    case "application/json":
          $articles = json_decode($response->getContent(), true);
          $articles = $this->array_change_key_case_recursive($articles["Data"]);
          foreach ($articles as $key => $value) {
            $productSystem = $this->productSystem->findOneBySku($value["sku_provider"]);
            if (null === $productSystem) {
              $productSystem = new ProductSystem();
            }
            $this->basic_product($productSystem, $value, 'json');
            $productSystem->setNew($value["new"]);
            $productSystem->setActive($value["active"]);
            $productSystem->setProductImages($value["images"]);

            $this->persistEntity($productSystem);

            if (isset($value["attributes"])) {
              foreach ($value["attributes"] as $key => $attr) {
                $attributeValue = $attr["attribute_value"];
                $attributeName = $attr["attribute_name"];
                $this->fill_attr_product($productSystem, $attributeName, $attributeValue);
              }
            }
          }
			    break;

			    case "application/xml":
          $articles = simplexml_load_file($url);
          foreach ($articles->Articulo as $articulo) {
            $productSystem = $this->productSystem->findOneBySku($articulo->Codigo);
            if (null === $productSystem) {
              $productSystem = new ProductSystem();
            }
            $productSystem->setSku($articulo->Codigo);
            $productSystem->setDescription($articulo->Descripcion);
            $productSystem->setEan13($articulo->CodigoBarras);
            $productSystem->setPvp((float)$articulo->PrecioBase);
            $productSystem->setPriceCatalog((float)$articulo->Precio);
            if (!empty($articulo->Surtido)) {
              $productSystem->setAssortment((int)$articulo->Surtido);
            }
            $productSystem->setStock((int)$articulo->Cantidad);
            $productSystem->setStockCatalog((int)$articulo->StockDisponible);
            $productSystem->setStockToShow((int)$articulo->StockTeorico);
            $productSystem->setStockAvailable((int)$articulo->StockReal);
            $productSystem->setVmd((int)$articulo->VMD);

            $this->persistEntity($productSystem);
          }
			    break;

			    case "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet":
          $file_name = basename($url);
          if(file_put_contents( $file_name,file_get_contents($url))) {
            $dir = './';
            $save_file_loc = $dir . $file_name;
          }
          else {
            $message = 'File downloading failed.';
            $this->io(sprintf('Error: "%s"', $message));
            return Command::FAILURE; 
          }
  
          if ( $xlsx = SimpleXLSX::parse($save_file_loc) ) {
            $header_values = $rows = [];
            foreach ( $xlsx->rows() as $k => $r ) {
              if ( $k === 0 ) {
                $header_values = $r;
                continue;
              }
              $rows[] = array_combine( $header_values, $r );
            }
            foreach ($rows as $key => $value) {
              $productSystem = $this->productSystem->findOneBySku($value["sku_provider"]);
              if (null === $productSystem) {
                $productSystem = new ProductSystem();
              }
              $this->basic_product($productSystem, $value, 'excel');
              $productSystem->setCategoryName2($value["category_supplier_name2"]);
              $productSystem->setCategoryName3($value["category_supplier_name3"]);
              $productSystem->setWidth($value["width"]);
              $productSystem->setHeight($value["height"]);
              if ($value["length"] != null) {
                $productSystem->setLength($value["length"]);
              }
              $productSystem->setWeight($value["weight (KG)"]);
              if (isset($value["width2"])) {
                $productSystem->setWidth2($value["width2"]);
              }
              if (isset($value["height2"])) {
                $productSystem->setHeight2($value["height2"]);
              }
              if (isset($value["length2"])) {
                $productSystem->setLength2($value["length2"]);
              }
              
              $productSystem->setCbm($value["cbm"]);
              $this->persistEntity($productSystem);
                
              for ($i=1; $i < 69; $i++) { 
                $attr_value = "value_" . $i;
                $attributeValue = $value[$attr_value];
                if ($value[$attr_value] != null) {
                  $label = "attribute_" . $i;
                  $attributeName = $value[$label];
                  $this->fill_attr_product($productSystem, $attributeName, $attributeValue);
                }
              }
            }
          } else {
            $message = SimpleXLSX::parseError();
            $this->io(sprintf('Error: "%s"', $message));
            return Command::FAILURE; 
          }
          unlink($file_name);
          break;

          default:
            $message = 'File extension not supported';
            $this->io(sprintf('Error: "%s"', $message));
            return Command::FAILURE; 
          break;
			}

      return Command::SUCCESS;
    }

    /**
     * The command help is usually included in the configure() method, but when
     * it's too long, it's better to define a separate method to maintain the
     * code readability.
     */
    private function getCommandHelp(): string
    {
      return <<<'HELP'
The <info>%command.name%</info> command checks an URL passed to check the file and storage the info on it:

  <info>php %command.full_name%</info> <comment>url</comment>

By default the command checks what type of file is passed on the url. After that, the information is revised
and stored in the database. It checks if the information stored previously is the same or it has to update it.

HELP;
    }

    public function basic_product($productSystem, $value, $type) {
      $productSystem->setSku($value["sku_provider"]);
      if (str_contains($value["ean"], ',')) {
        $eans = explode(",", $value["ean"]);
        $productSystem->setProductEans($eans);
      } else {
        $productSystem->setEan13($value["ean"]);
      }

      if ($type = 'json') {
        $productSystem->setDescription($value["provider_full_description"]);
      } else {
        $productSystem->setDescription($value["provider_short_description"]);
      }

      $productSystem->setName($value["provider_name"]);
      if (isset($value["intrastat"])) {
        $productSystem->setInstrastat($value["intrastat"]);
      }
      $productSystem->setBrandName($value["brand_supplier_name"]);
      $productSystem->setCategoryName($value["category_supplier_name"]);
      $productSystem->setWidthPackaging($value["width_packaging"]);
      $productSystem->setHeightPackaging($value["height_packaging"]);
      $productSystem->setLengthPackaging($value["length_packaging"]);
      $productSystem->setWeightPackaging($value["weight_packaging"]);
    }

    public function fill_attr_product($productSystem, $attributeName, $attributeValue) {
      $attribute = $this->productSystemAttribute->findOneByName($attributeName);
      if (null === $attribute) {
        $attribute = new ProductSystemAttribute();
        $attribute->setName($attributeName);
        $this->persistEntity($attribute);
      }
      $productAttribute = $this->productAttribute->findOneBy([
        'product' => $productSystem,
        'attribute'=> $attribute
      ]);
      if (null === $productAttribute) {
        $productAttribute = new ProductAttribute();
        $productAttribute->setProduct($productSystem);
        $productAttribute->setAttribute($attribute);
      }
      $productAttribute->setValue($attributeValue);
      $this->persistEntity($productAttribute);
    }

    public function persistEntity($entity) {
      try {
        $entity->setLastUpdate(new \DateTime()); 
        $this->entityManager->persist($entity);
        $this->entityManager->flush(); 
      }
      catch(DBALException $e) {
        $message = sprintf('DBALException [%i]: %s', $e->getCode(), $e->getMessage());
        $this->io(sprintf('Error: "%s"', $message));
        return Command::FAILURE; 
      }
    }

    public function array_change_key_case_recursive($arr)
    {
      return array_map(function($item){
          if(is_array($item))
              $item = $this->array_change_key_case_recursive($item);
          return $item;
      },array_change_key_case($arr));
    }

}