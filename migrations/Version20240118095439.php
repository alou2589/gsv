<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118095439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE justification_absence (id INT AUTO_INCREMENT NOT NULL, affectation_id INT NOT NULL, operateur_id INT DEFAULT NULL, nb_jours_absence INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_fin DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', upload_justificatif VARCHAR(255) DEFAULT NULL, status_validation VARCHAR(255) DEFAULT NULL, INDEX IDX_AEB54F6A6D0ABA22 (affectation_id), INDEX IDX_AEB54F6A3F192FC (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE justification_absence ADD CONSTRAINT FK_AEB54F6A6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE justification_absence ADD CONSTRAINT FK_AEB54F6A3F192FC FOREIGN KEY (operateur_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE justification_absence DROP FOREIGN KEY FK_AEB54F6A6D0ABA22');
        $this->addSql('ALTER TABLE justification_absence DROP FOREIGN KEY FK_AEB54F6A3F192FC');
        $this->addSql('DROP TABLE justification_absence');
    }
}
