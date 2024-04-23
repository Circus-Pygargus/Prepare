<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240423115443 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE idea (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, needed TINYINT(1) NOT NULL, proposed TINYINT(1) NOT NULL, owned TINYINT(1) NOT NULL, validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, category_id INT NOT NULL, created_by_id INT NOT NULL, UNIQUE INDEX UNIQ_A8BCA45989D9B62 (slug), INDEX IDX_A8BCA4512469DE2 (category_id), INDEX IDX_A8BCA45B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci`');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA4512469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE idea ADD CONSTRAINT FK_A8BCA45B03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251EB03A8386');
        $this->addSql('DROP TABLE item');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, quantity VARCHAR(255) CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, comment LONGTEXT CHARACTER SET utf8mb4 DEFAULT NULL COLLATE `utf8mb4_unicode_ci`, needed TINYINT(1) NOT NULL, proposed TINYINT(1) NOT NULL, owned TINYINT(1) NOT NULL, validated TINYINT(1) NOT NULL, created_at DATETIME NOT NULL, category_id INT NOT NULL, created_by_id INT NOT NULL, slug VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, INDEX IDX_1F1B251EB03A8386 (created_by_id), UNIQUE INDEX UNIQ_1F1B251E989D9B62 (slug), INDEX IDX_1F1B251E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251EB03A8386 FOREIGN KEY (created_by_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA4512469DE2');
        $this->addSql('ALTER TABLE idea DROP FOREIGN KEY FK_A8BCA45B03A8386');
        $this->addSql('DROP TABLE idea');
    }
}
