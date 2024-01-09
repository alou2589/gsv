<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221102003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE fichiers (id INT AUTO_INCREMENT NOT NULL, type_fichier_id INT NOT NULL, volontaire_statut_id INT DEFAULT NULL, nom_fichier VARCHAR(255) NOT NULL, fichier VARCHAR(255) NOT NULL, date_enregistrement DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_969DB4AB12928ADB (type_fichier_id), INDEX IDX_969DB4AB9EE12A67 (volontaire_statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fichiers ADD CONSTRAINT FK_969DB4AB12928ADB FOREIGN KEY (type_fichier_id) REFERENCES type_fichier (id)');
        $this->addSql('ALTER TABLE fichiers ADD CONSTRAINT FK_969DB4AB9EE12A67 FOREIGN KEY (volontaire_statut_id) REFERENCES statut_volontaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE fichiers DROP FOREIGN KEY FK_969DB4AB12928ADB');
        $this->addSql('ALTER TABLE fichiers DROP FOREIGN KEY FK_969DB4AB9EE12A67');
        $this->addSql('DROP TABLE fichiers');
    }
}
