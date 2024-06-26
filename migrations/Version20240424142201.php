<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424142201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea ADD measurement_type_id INT NOT NULL');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA458B4CC8FE FOREIGN KEY (measurement_type_id) REFERENCES measurement_type (id)');
        $this->addSql('CREATE INDEX IDX_A8BCA458B4CC8FE ON idea (measurement_type_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA458B4CC8FE');
        $this->addSql('DROP INDEX IDX_A8BCA458B4CC8FE ON idea');
        $this->addSql('ALTER TABLE idea DROP measurement_type_id');
    }
}
