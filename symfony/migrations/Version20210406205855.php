<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210406205855 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE product_attribute (id INT AUTO_INCREMENT NOT NULL, prod_id INT DEFAULT NULL, attr_id INT DEFAULT NULL, value VARCHAR(255) DEFAULT NULL, INDEX IDX_94DA59761C83F75 (prod_id), INDEX IDX_94DA5976747AE5C2 (attr_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_system (id INT AUTO_INCREMENT NOT NULL, sku VARCHAR(255) NOT NULL, ean13 VARCHAR(255) DEFAULT NULL, eans LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', description VARCHAR(255) DEFAULT NULL, name VARCHAR(255) DEFAULT NULL, intrastat VARCHAR(255) DEFAULT NULL, brand_name VARCHAR(255) DEFAULT NULL, category_name VARCHAR(255) DEFAULT NULL, category_name2 VARCHAR(255) DEFAULT NULL, category_name3 VARCHAR(255) DEFAULT NULL, pvp DOUBLE PRECISION DEFAULT NULL, price_catalog DOUBLE PRECISION DEFAULT NULL, assortment INT DEFAULT NULL, stock INT DEFAULT NULL, stock_catalog INT DEFAULT NULL, stock_to_show INT DEFAULT NULL, stock_available INT DEFAULT NULL, vmd INT DEFAULT NULL, weight DOUBLE PRECISION DEFAULT NULL, height DOUBLE PRECISION DEFAULT NULL, width DOUBLE PRECISION DEFAULT NULL, length DOUBLE PRECISION DEFAULT NULL, height2 DOUBLE PRECISION DEFAULT NULL, width2 DOUBLE PRECISION DEFAULT NULL, length2 DOUBLE PRECISION DEFAULT NULL, weight_packaging DOUBLE PRECISION DEFAULT NULL, height_packaging DOUBLE PRECISION DEFAULT NULL, width_packaging DOUBLE PRECISION DEFAULT NULL, length_packaging DOUBLE PRECISION DEFAULT NULL, cbm DOUBLE PRECISION DEFAULT NULL, new TINYINT(1) DEFAULT NULL, active TINYINT(1) DEFAULT NULL, product_images LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_system_attribute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA59761C83F75 FOREIGN KEY (prod_id) REFERENCES product_system (id)');
        $this->addSql('ALTER TABLE product_attribute ADD CONSTRAINT FK_94DA5976747AE5C2 FOREIGN KEY (attr_id) REFERENCES product_system_attribute (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA59761C83F75');
        $this->addSql('ALTER TABLE product_attribute DROP FOREIGN KEY FK_94DA5976747AE5C2');
        $this->addSql('DROP TABLE product_attribute');
        $this->addSql('DROP TABLE product_system');
        $this->addSql('DROP TABLE product_system_attribute');
    }
}
