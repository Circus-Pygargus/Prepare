<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426124429 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE measurement_unit (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, coef INT NOT NULL, measurement_type_id INT NOT NULL, INDEX IDX_AF2DE8028B4CC8FE (measurement_type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE measurement_unit ADD CONSTRAINT FK_AF2DE8028B4CC8FE FOREIGN KEY (measurement_type_id) REFERENCES measurement_type (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE measurement_unit DROP FOREIGN KEY FK_AF2DE8028B4CC8FE');
        $this->addSql('DROP TABLE measurement_unit');
    }
}
