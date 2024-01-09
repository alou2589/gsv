<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219105926 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE statut_volontaire (id INT AUTO_INCREMENT NOT NULL, volontaire_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, date_recrutement DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_CE9791629DEA3983 (volontaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE statut_volontaire ADD CONSTRAINT FK_CE9791629DEA3983 FOREIGN KEY (volontaire_id) REFERENCES volontaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE statut_volontaire DROP FOREIGN KEY FK_CE9791629DEA3983');
        $this->addSql('DROP TABLE statut_volontaire');
    }
}
