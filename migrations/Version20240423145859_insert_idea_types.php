<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423145859_insert_idea_types extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
            INSERT INTO idea_type (name) VALUES ('objet');
            INSERT INTO idea_type (name) VALUES ('action');
            SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $sql = <<<SQL
            DELETE FROM idea_type WHERE name = 'objet';
            DELETE FROM idea_type WHERE name = 'action';
            SQL;

        $this->addSql($sql);
    }
}
