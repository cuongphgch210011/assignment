<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220627030242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE order_detail_product');
        $this->addSql('ALTER TABLE `order` ADD orderdetail_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F529939817E8A46A FOREIGN KEY (orderdetail_id) REFERENCES order_detail (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F529939817E8A46A ON `order` (orderdetail_id)');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F466F90D45B');
        $this->addSql('DROP INDEX UNIQ_ED896F466F90D45B ON order_detail');
        $this->addSql('ALTER TABLE order_detail ADD product_id INT DEFAULT NULL, DROP orderid_id, DROP price');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F464584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_ED896F464584665A ON order_detail (product_id)');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_detail_product (order_detail_id INT NOT NULL, product_id INT NOT NULL, INDEX IDX_DCF554C864577843 (order_detail_id), INDEX IDX_DCF554C84584665A (product_id), PRIMARY KEY(order_detail_id, product_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_detail_product ADD CONSTRAINT FK_DCF554C864577843 FOREIGN KEY (order_detail_id) REFERENCES order_detail (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_detail_product ADD CONSTRAINT FK_DCF554C84584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F529939817E8A46A');
        $this->addSql('DROP INDEX UNIQ_F529939817E8A46A ON `order`');
        $this->addSql('ALTER TABLE `order` DROP orderdetail_id');
        $this->addSql('ALTER TABLE order_detail DROP FOREIGN KEY FK_ED896F464584665A');
        $this->addSql('DROP INDEX IDX_ED896F464584665A ON order_detail');
        $this->addSql('ALTER TABLE order_detail ADD orderid_id INT NOT NULL, ADD price DOUBLE PRECISION NOT NULL, DROP product_id');
        $this->addSql('ALTER TABLE order_detail ADD CONSTRAINT FK_ED896F466F90D45B FOREIGN KEY (orderid_id) REFERENCES `order` (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_ED896F466F90D45B ON order_detail (orderid_id)');
        $this->addSql('ALTER TABLE product CHANGE category_id category_id INT NOT NULL');
    }
}
