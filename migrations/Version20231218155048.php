<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231218155048 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departements ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE departements ADD CONSTRAINT FK_CF7489B298260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_CF7489B298260155 ON departements (region_id)');
        $this->addSql('ALTER TABLE service_departemental ADD departement_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_departemental ADD CONSTRAINT FK_1BEDAE86CCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('CREATE INDEX IDX_1BEDAE86CCF9E01E ON service_departemental (departement_id)');
        $this->addSql('ALTER TABLE service_regional ADD region_id INT NOT NULL');
        $this->addSql('ALTER TABLE service_regional ADD CONSTRAINT FK_33922DCF98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('CREATE INDEX IDX_33922DCF98260155 ON service_regional (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE departements DROP FOREIGN KEY FK_CF7489B298260155');
        $this->addSql('DROP INDEX IDX_CF7489B298260155 ON departements');
        $this->addSql('ALTER TABLE departements DROP region_id');
        $this->addSql('ALTER TABLE service_departemental DROP FOREIGN KEY FK_1BEDAE86CCF9E01E');
        $this->addSql('DROP INDEX IDX_1BEDAE86CCF9E01E ON service_departemental');
        $this->addSql('ALTER TABLE service_departemental DROP departement_id');
        $this->addSql('ALTER TABLE service_regional DROP FOREIGN KEY FK_33922DCF98260155');
        $this->addSql('DROP INDEX IDX_33922DCF98260155 ON service_regional');
        $this->addSql('ALTER TABLE service_regional DROP region_id');
    }
}
