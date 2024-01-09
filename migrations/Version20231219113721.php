<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219113721 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_pro CHANGE date_delivrance date_delivrance DATE NOT NULL, CHANGE date_expiration date_expiration DATE NOT NULL');
        $this->addSql('ALTER TABLE statut_volontaire CHANGE date_recrutement date_recrutement DATE NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_pro CHANGE date_delivrance date_delivrance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', CHANGE date_expiration date_expiration DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
        $this->addSql('ALTER TABLE statut_volontaire CHANGE date_recrutement date_recrutement DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\'');
    }
}
