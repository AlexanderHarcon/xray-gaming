<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902072802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE winning (id INT AUTO_INCREMENT NOT NULL, user_id_id INT DEFAULT NULL, product_id_id INT DEFAULT NULL, created_at DATETIME NOT NULL, INDEX IDX_90D64289D86650F (user_id_id), INDEX IDX_90D6428DE18E50B (product_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE winning ADD CONSTRAINT FK_90D64289D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE winning ADD CONSTRAINT FK_90D6428DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE cscase CHANGE category_id category_id INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE winning DROP FOREIGN KEY FK_90D64289D86650F');
        $this->addSql('ALTER TABLE winning DROP FOREIGN KEY FK_90D6428DE18E50B');
        $this->addSql('DROP TABLE winning');
        $this->addSql('ALTER TABLE cscase CHANGE category_id category_id INT DEFAULT 1');
    }
}
