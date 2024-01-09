<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231226124126 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat ADD volontaire_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939DEA3983 FOREIGN KEY (volontaire_id) REFERENCES volontaire (id)');
        $this->addSql('CREATE INDEX IDX_603499939DEA3983 ON contrat (volontaire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939DEA3983');
        $this->addSql('DROP INDEX IDX_603499939DEA3983 ON contrat');
        $this->addSql('ALTER TABLE contrat DROP volontaire_id');
    }
}
