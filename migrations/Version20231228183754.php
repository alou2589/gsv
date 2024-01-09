<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231228183754 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bilan_volontaire (id INT AUTO_INCREMENT NOT NULL, affectation_id INT DEFAULT NULL, nbjour_presence INT NOT NULL, nbjour_absence INT NOT NULL, INDEX IDX_61A8CE0B6D0ABA22 (affectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bilan_volontaire ADD CONSTRAINT FK_61A8CE0B6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bilan_volontaire DROP FOREIGN KEY FK_61A8CE0B6D0ABA22');
        $this->addSql('DROP TABLE bilan_volontaire');
    }
}
