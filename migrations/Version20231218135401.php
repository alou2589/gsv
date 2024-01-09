<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218135401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE service_departemental (id INT AUTO_INCREMENT NOT NULL, service_regional_id INT DEFAULT NULL, nom_sdc VARCHAR(255) NOT NULL, departement VARCHAR(255) NOT NULL, INDEX IDX_1BEDAE86C299BCF9 (service_regional_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE service_departemental ADD CONSTRAINT FK_1BEDAE86C299BCF9 FOREIGN KEY (service_regional_id) REFERENCES service_regional (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_departemental DROP FOREIGN KEY FK_1BEDAE86C299BCF9');
        $this->addSql('DROP TABLE service_departemental');
    }
}
