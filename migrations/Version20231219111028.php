<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219111028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carte_pro (id INT AUTO_INCREMENT NOT NULL, affectation_id INT NOT NULL, date_delivrance DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', date_expiration DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', qr_code_volontaire LONGTEXT NOT NULL, photo_volontaire VARCHAR(255) DEFAULT NULL, INDEX IDX_22AB6F1B6D0ABA22 (affectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carte_pro ADD CONSTRAINT FK_22AB6F1B6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carte_pro DROP FOREIGN KEY FK_22AB6F1B6D0ABA22');
        $this->addSql('DROP TABLE carte_pro');
    }
}
