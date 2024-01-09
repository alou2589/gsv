<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221135823 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE feuille_presence (id INT AUTO_INCREMENT NOT NULL, service_departemental_id INT DEFAULT NULL, operateur_id INT DEFAULT NULL, numero_feuille INT NOT NULL, date_feuille DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_F19E25E96DC6ADBB (service_departemental_id), INDEX IDX_F19E25E93F192FC (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE feuille_presence ADD CONSTRAINT FK_F19E25E96DC6ADBB FOREIGN KEY (service_departemental_id) REFERENCES service_departemental (id)');
        $this->addSql('ALTER TABLE feuille_presence ADD CONSTRAINT FK_F19E25E93F192FC FOREIGN KEY (operateur_id) REFERENCES user (id)');
        $this->addSql('DROP TABLE etat_temps_presence');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE etat_temps_presence (id INT AUTO_INCREMENT NOT NULL, nom_etat_tp VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE feuille_presence DROP FOREIGN KEY FK_F19E25E96DC6ADBB');
        $this->addSql('ALTER TABLE feuille_presence DROP FOREIGN KEY FK_F19E25E93F192FC');
        $this->addSql('DROP TABLE feuille_presence');
    }
}
