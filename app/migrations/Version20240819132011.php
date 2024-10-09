<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240819132011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cscase ADD category_id INT DEFAULT 1, DROP category_id_id');
        $this->addSql('ALTER TABLE cscase ADD CONSTRAINT FK_D89C005012469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_D89C005012469DE2 ON cscase (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cscase DROP FOREIGN KEY FK_D89C005012469DE2');
        $this->addSql('DROP INDEX IDX_D89C005012469DE2 ON cscase');
        $this->addSql('ALTER TABLE cscase ADD category_id_id VARCHAR(255) NOT NULL, DROP category_id');
    }
}
