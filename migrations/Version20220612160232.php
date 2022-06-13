<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612160232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kyu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stars INT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD kyu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649E2D29008 FOREIGN KEY (kyu_id) REFERENCES kyu (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649E2D29008 ON user (kyu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649E2D29008');
        $this->addSql('DROP TABLE kyu');
        $this->addSql('DROP INDEX IDX_8D93D649E2D29008 ON user');
        $this->addSql('ALTER TABLE user DROP kyu_id');
    }
}
