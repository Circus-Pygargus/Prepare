<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424133939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE measurement_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, idea_type_id INT NOT NULL, INDEX IDX_FF48B37886D39D18 (idea_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE measurement_type ADD CONSTRAINT FK_FF48B37886D39D18 FOREIGN KEY (idea_type_id) REFERENCES idea_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE measurement_type DROP FOREIGN KEY FK_FF48B37886D39D18');
        $this->addSql('DROP TABLE measurement_type');
    }
}
