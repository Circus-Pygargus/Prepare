<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240212175500_insert_admin extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('INSERT INTO user (username, password, roles, is_active, created_at)
              VALUES ("Riri", "$2y$13$AZbTJLOKQRwT5DQLGHJOleoK6aMcl0FYO/LwG.0CqMJyBBUKCgNz.", \'["ROLE_ADMIN"]\', true, NOW())');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM user WHERE username LIKE "test1"');
    }
}
