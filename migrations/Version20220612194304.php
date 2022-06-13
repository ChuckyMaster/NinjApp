<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612194304 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kyu ADD dan_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE kyu ADD CONSTRAINT FK_6551BADFC40C2E00 FOREIGN KEY (dan_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6551BADFC40C2E00 ON kyu (dan_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kyu DROP FOREIGN KEY FK_6551BADFC40C2E00');
        $this->addSql('DROP INDEX UNIQ_6551BADFC40C2E00 ON kyu');
        $this->addSql('ALTER TABLE kyu DROP dan_id');
    }
}
