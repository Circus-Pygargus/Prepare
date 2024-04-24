<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424134123_insert_measurement_types extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Poids', id FROM idea_type WHERE idea_type.name = 'objet';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Volume', id FROM idea_type WHERE idea_type.name = 'objet';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Taille', id FROM idea_type WHERE idea_type.name = 'objet';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Surface', id FROM idea_type WHERE idea_type.name = 'objet';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Aucun', id FROM idea_type WHERE idea_type.name = 'objet';

            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Durée', id FROM idea_type WHERE idea_type.name = 'action';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Horodatage', id FROM idea_type WHERE idea_type.name = 'action';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Distance', id FROM idea_type WHERE idea_type.name = 'action';
            INSERT INTO measurement_type (name, idea_type_id)
                SELECT 'Aucun', id FROM idea_type WHERE idea_type.name = 'action';
            SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
            DELETE FROM measurement_type WHERE name = 'Distance';
            DELETE FROM measurement_type WHERE name = 'Horodatage';
            DELETE FROM measurement_type WHERE name = 'Durée';
            DELETE FROM measurement_type WHERE name = 'Surface';
            DELETE FROM measurement_type WHERE name = 'Taille';
            DELETE FROM measurement_type WHERE name = 'Volume';
            DELETE FROM measurement_type WHERE name = 'Poids';
            SQL;

        $this->addSql($sql);
    }
}
