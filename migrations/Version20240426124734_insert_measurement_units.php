<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240426124734_insert_measurement_units extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $sql = <<<SQL
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 't', 1000000000, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'kg', 1000000, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'hg', 100000, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dag', 10000, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'g', 1000, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dg', 100, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'cg', 10, id FROM measurement_type WHERE name = 'Poids';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'mg', 1, id FROM measurement_type WHERE name = 'Poids';

            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'm', 1000, id FROM measurement_type WHERE name = 'Taille';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dm', 100, id FROM measurement_type WHERE name = 'Taille';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'cm', 10, id FROM measurement_type WHERE name = 'Taille';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'mm', 1, id FROM measurement_type WHERE name = 'Taille';

            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'km', 1000, id FROM measurement_type WHERE name = 'Distance';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'hm', 100, id FROM measurement_type WHERE name = 'Distance';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dam', 10, id FROM measurement_type WHERE name = 'Distance';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'm', 1, id FROM measurement_type WHERE name = 'Distance';

            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'm²', 1000000, id FROM measurement_type WHERE name = 'Surface';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dm²', 10000, id FROM measurement_type WHERE name = 'Surface';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'cm²', 100, id FROM measurement_type WHERE name = 'Surface';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'mm²', 1, id FROM measurement_type WHERE name = 'Surface';

            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'm³', 1000000, id FROM measurement_type WHERE name = 'Volume';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'l', 1000, id FROM measurement_type WHERE name = 'Volume';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'dl', 100, id FROM measurement_type WHERE name = 'Volume';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'cl', 10, id FROM measurement_type WHERE name = 'Volume';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'ml', 1, id FROM measurement_type WHERE name = 'Volume';

            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'j', 86400000, id FROM measurement_type WHERE name = 'Durée';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'h', 3600000, id FROM measurement_type WHERE name = 'Durée';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'min', 60000, id FROM measurement_type WHERE name = 'Durée';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 's', 1000, id FROM measurement_type WHERE name = 'Durée';
            INSERT INTO measurement_unit (name, coef, measurement_type_id)
                SELECT 'ms', 1, id FROM measurement_type WHERE name = 'Durée';
            SQL;

        $this->addSql($sql);
    }

    public function down(Schema $schema): void
    {
        $sql = <<<SQL
            DELETE FROM measurement_unit WHERE name = 'ms';
            DELETE FROM measurement_unit WHERE name = 's';
            DELETE FROM measurement_unit WHERE name = 'min';
            DELETE FROM measurement_unit WHERE name = 'h';
            DELETE FROM measurement_unit WHERE name = 'j';

            DELETE FROM measurement_unit WHERE name = 'ml';
            DELETE FROM measurement_unit WHERE name = 'cl';
            DELETE FROM measurement_unit WHERE name = 'dl';
            DELETE FROM measurement_unit WHERE name = 'l';
            DELETE FROM measurement_unit WHERE name = 'm³';

            DELETE FROM measurement_unit WHERE name = 'mm²';
            DELETE FROM measurement_unit WHERE name = 'cm²';
            DELETE FROM measurement_unit WHERE name = 'dm²';
            DELETE FROM measurement_unit WHERE name = 'm²';

            DELETE FROM measurement_unit WHERE name = 'm' AND coef = 1;
            DELETE FROM measurement_unit WHERE name = 'dam';
            DELETE FROM measurement_unit WHERE name = 'hm';
            DELETE FROM measurement_unit WHERE name = 'km';

            DELETE FROM measurement_unit WHERE name = 'mm';
            DELETE FROM measurement_unit WHERE name = 'cm';
            DELETE FROM measurement_unit WHERE name = 'dm';
            DELETE FROM measurement_unit WHERE name = 'm' and coef = 1000;

            DELETE FROM measurement_unit WHERE name = 'mg';
            DELETE FROM measurement_unit WHERE name = 'cg';
            DELETE FROM measurement_unit WHERE name = 'dg';
            DELETE FROM measurement_unit WHERE name = 'g';
            DELETE FROM measurement_unit WHERE name = 'dag';
            DELETE FROM measurement_unit WHERE name = 'hg';
            DELETE FROM measurement_unit WHERE name = 'kg';
            DELETE FROM measurement_unit WHERE name = 't';
            SQL;

        $this->addSql($sql);
    }
}
