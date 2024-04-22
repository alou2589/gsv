<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409144136 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP status_affectation');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993520D03A');
        $this->addSql('DROP INDEX IDX_60349993520D03A ON contrat');
        $this->addSql('ALTER TABLE contrat DROP type_contrat_id, DROP status_contrat');
        $this->addSql('ALTER TABLE emargement DROP etat_tp');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation ADD status_affectation VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE contrat ADD type_contrat_id INT NOT NULL, ADD status_contrat VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993520D03A FOREIGN KEY (type_contrat_id) REFERENCES type_contrat (id)');
        $this->addSql('CREATE INDEX IDX_60349993520D03A ON contrat (type_contrat_id)');
        $this->addSql('ALTER TABLE emargement ADD etat_tp VARCHAR(255) DEFAULT NULL');
    }
}
