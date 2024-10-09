<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819110705 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cscase (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, image_path VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE product ADD c_scase_id INT DEFAULT 0');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD412C45A FOREIGN KEY (c_scase_id) REFERENCES cscase (id)');
        $this->addSql('CREATE INDEX IDX_D34A04AD412C45A ON product (c_scase_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD412C45A');
        $this->addSql('DROP TABLE cscase');
        $this->addSql('DROP INDEX IDX_D34A04AD412C45A ON product');
        $this->addSql('ALTER TABLE product DROP c_scase_id');
    }
}
