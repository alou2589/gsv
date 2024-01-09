<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231221203701 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emargement (id INT AUTO_INCREMENT NOT NULL, etat_tp_id INT DEFAULT NULL, affectation_id INT DEFAULT NULL, feuille_id INT DEFAULT NULL, heure DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_71BBB2507ED82115 (etat_tp_id), INDEX IDX_71BBB2506D0ABA22 (affectation_id), INDEX IDX_71BBB25065150016 (feuille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB2507ED82115 FOREIGN KEY (etat_tp_id) REFERENCES etat_temps_presence (id)');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB2506D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB25065150016 FOREIGN KEY (feuille_id) REFERENCES feuille_presence (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB2507ED82115');
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB2506D0ABA22');
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB25065150016');
        $this->addSql('DROP TABLE emargement');
    }
}
