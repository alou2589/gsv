<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231219105438 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D36DC6ADBB');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3A0905086');
        $this->addSql('DROP TABLE affectation');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, service_departemental_id INT NOT NULL, poste_id INT NOT NULL, date_affectation DATE NOT NULL, INDEX IDX_F4DD61D3A0905086 (poste_id), INDEX IDX_F4DD61D36DC6ADBB (service_departemental_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D36DC6ADBB FOREIGN KEY (service_departemental_id) REFERENCES service_departemental (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
    }
}
