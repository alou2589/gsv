<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240409141333 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, volontaire_statut_id INT NOT NULL, service_departemental_id INT NOT NULL, poste_id INT NOT NULL, date_affectation DATE NOT NULL, INDEX IDX_F4DD61D39EE12A67 (volontaire_statut_id), INDEX IDX_F4DD61D36DC6ADBB (service_departemental_id), INDEX IDX_F4DD61D3A0905086 (poste_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bilan_volontaire (id INT AUTO_INCREMENT NOT NULL, affectation_id INT DEFAULT NULL, nbjour_presence INT DEFAULT NULL, nbjour_absence INT DEFAULT NULL, nb_jours_ouvrables INT DEFAULT NULL, annee INT DEFAULT NULL, mois VARCHAR(255) DEFAULT NULL, nb_jours_absences_justifiees INT DEFAULT NULL, INDEX IDX_61A8CE0B6D0ABA22 (affectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bulletin_volontaire (id INT AUTO_INCREMENT NOT NULL, bilan_volontaire_id INT DEFAULT NULL, paie_presence INT NOT NULL, paie_absence INT NOT NULL, forfait INT NOT NULL, total_paie INT DEFAULT NULL, paie_absences_justifiees INT DEFAULT NULL, INDEX IDX_E9D3B474E760FBAA (bilan_volontaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carte_pro (id INT AUTO_INCREMENT NOT NULL, affectation_id INT NOT NULL, date_delivrance DATE NOT NULL, date_expiration DATE NOT NULL, qr_code_volontaire LONGTEXT NOT NULL, photo_volontaire VARCHAR(255) DEFAULT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_22AB6F1B6D0ABA22 (affectation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, operateur_id INT NOT NULL, volontaire_id INT NOT NULL, date_debut DATE NOT NULL, date_fin DATE NOT NULL, INDEX IDX_603499933F192FC (operateur_id), INDEX IDX_603499939DEA3983 (volontaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE departements (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom_departement VARCHAR(255) NOT NULL, INDEX IDX_CF7489B298260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE emargement (id INT AUTO_INCREMENT NOT NULL, etat_tp_id INT DEFAULT NULL, affectation_id INT DEFAULT NULL, feuille_id INT DEFAULT NULL, heure DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_71BBB2507ED82115 (etat_tp_id), INDEX IDX_71BBB2506D0ABA22 (affectation_id), INDEX IDX_71BBB25065150016 (feuille_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_temps_presence (id INT AUTO_INCREMENT NOT NULL, nom_etat_tp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE feuille_presence (id INT AUTO_INCREMENT NOT NULL, service_departemental_id INT DEFAULT NULL, operateur_id INT DEFAULT NULL, numero_feuille VARCHAR(255) NOT NULL, active VARCHAR(255) DEFAULT NULL, date_feuille DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_F19E25E96DC6ADBB (service_departemental_id), INDEX IDX_F19E25E93F192FC (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fichiers (id INT AUTO_INCREMENT NOT NULL, type_fichier_id INT NOT NULL, volontaire_statut_id INT DEFAULT NULL, nom_fichier VARCHAR(255) NOT NULL, fichier VARCHAR(255) DEFAULT NULL, date_enregistrement DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', INDEX IDX_969DB4AB12928ADB (type_fichier_id), INDEX IDX_969DB4AB9EE12A67 (volontaire_statut_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE justification_absence (id INT AUTO_INCREMENT NOT NULL, affectation_id INT NOT NULL, operateur_id INT DEFAULT NULL, nb_jours_absence INT DEFAULT NULL, date_debut DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', date_fin DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', upload_justificatif VARCHAR(255) DEFAULT NULL, status_validation VARCHAR(255) DEFAULT NULL, date_justification DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', type_justificatif VARCHAR(255) NOT NULL, INDEX IDX_AEB54F6A6D0ABA22 (affectation_id), INDEX IDX_AEB54F6A3F192FC (operateur_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE poste (id INT AUTO_INCREMENT NOT NULL, nom_poste VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_7C890FABD671933E (nom_poste), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, nom_region VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_A26779F38FAD6E21 (nom_region), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE role (id INT AUTO_INCREMENT NOT NULL, nom_role VARCHAR(255) NOT NULL, libelle VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_57698A6AA5B94004 (nom_role), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_departemental (id INT AUTO_INCREMENT NOT NULL, service_regional_id INT DEFAULT NULL, departement_id INT NOT NULL, nom_sdc VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_1BEDAE86CE16B109 (nom_sdc), INDEX IDX_1BEDAE86C299BCF9 (service_regional_id), INDEX IDX_1BEDAE86CCF9E01E (departement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_regional (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, nom_src VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_33922DCFD28E04DE (nom_src), INDEX IDX_33922DCF98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statut_volontaire (id INT AUTO_INCREMENT NOT NULL, volontaire_id INT NOT NULL, matricule VARCHAR(255) NOT NULL, date_recrutement DATE NOT NULL, INDEX IDX_CE9791629DEA3983 (volontaire_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_contrat (id INT AUTO_INCREMENT NOT NULL, nom_type_contrat VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_fichier (id INT AUTO_INCREMENT NOT NULL, nom_type_fichier VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, prenom VARCHAR(255) DEFAULT NULL, nom VARCHAR(255) DEFAULT NULL, matricule VARCHAR(9) NOT NULL, nb_connect INT DEFAULT NULL, pseudo VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), UNIQUE INDEX UNIQ_8D93D64912B2DC9C (matricule), UNIQUE INDEX UNIQ_8D93D64986CC499D (pseudo), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE volontaire (id INT AUTO_INCREMENT NOT NULL, prenom VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, genre VARCHAR(255) NOT NULL, date_naissance DATE NOT NULL, lieu_naissance VARCHAR(255) NOT NULL, adresse VARCHAR(255) DEFAULT NULL, telephone VARCHAR(9) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', numero_cin VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D39EE12A67 FOREIGN KEY (volontaire_statut_id) REFERENCES statut_volontaire (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D36DC6ADBB FOREIGN KEY (service_departemental_id) REFERENCES service_departemental (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D3A0905086 FOREIGN KEY (poste_id) REFERENCES poste (id)');
        $this->addSql('ALTER TABLE bilan_volontaire ADD CONSTRAINT FK_61A8CE0B6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE bulletin_volontaire ADD CONSTRAINT FK_E9D3B474E760FBAA FOREIGN KEY (bilan_volontaire_id) REFERENCES bilan_volontaire (id)');
        $this->addSql('ALTER TABLE carte_pro ADD CONSTRAINT FK_22AB6F1B6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499933F192FC FOREIGN KEY (operateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_603499939DEA3983 FOREIGN KEY (volontaire_id) REFERENCES volontaire (id)');
        $this->addSql('ALTER TABLE departements ADD CONSTRAINT FK_CF7489B298260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB2507ED82115 FOREIGN KEY (etat_tp_id) REFERENCES etat_temps_presence (id)');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB2506D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE emargement ADD CONSTRAINT FK_71BBB25065150016 FOREIGN KEY (feuille_id) REFERENCES feuille_presence (id)');
        $this->addSql('ALTER TABLE feuille_presence ADD CONSTRAINT FK_F19E25E96DC6ADBB FOREIGN KEY (service_departemental_id) REFERENCES service_departemental (id)');
        $this->addSql('ALTER TABLE feuille_presence ADD CONSTRAINT FK_F19E25E93F192FC FOREIGN KEY (operateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE fichiers ADD CONSTRAINT FK_969DB4AB12928ADB FOREIGN KEY (type_fichier_id) REFERENCES type_fichier (id)');
        $this->addSql('ALTER TABLE fichiers ADD CONSTRAINT FK_969DB4AB9EE12A67 FOREIGN KEY (volontaire_statut_id) REFERENCES statut_volontaire (id)');
        $this->addSql('ALTER TABLE justification_absence ADD CONSTRAINT FK_AEB54F6A6D0ABA22 FOREIGN KEY (affectation_id) REFERENCES affectation (id)');
        $this->addSql('ALTER TABLE justification_absence ADD CONSTRAINT FK_AEB54F6A3F192FC FOREIGN KEY (operateur_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_departemental ADD CONSTRAINT FK_1BEDAE86C299BCF9 FOREIGN KEY (service_regional_id) REFERENCES service_regional (id)');
        $this->addSql('ALTER TABLE service_departemental ADD CONSTRAINT FK_1BEDAE86CCF9E01E FOREIGN KEY (departement_id) REFERENCES departements (id)');
        $this->addSql('ALTER TABLE service_regional ADD CONSTRAINT FK_33922DCF98260155 FOREIGN KEY (region_id) REFERENCES regions (id)');
        $this->addSql('ALTER TABLE statut_volontaire ADD CONSTRAINT FK_CE9791629DEA3983 FOREIGN KEY (volontaire_id) REFERENCES volontaire (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D39EE12A67');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D36DC6ADBB');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D3A0905086');
        $this->addSql('ALTER TABLE bilan_volontaire DROP FOREIGN KEY FK_61A8CE0B6D0ABA22');
        $this->addSql('ALTER TABLE bulletin_volontaire DROP FOREIGN KEY FK_E9D3B474E760FBAA');
        $this->addSql('ALTER TABLE carte_pro DROP FOREIGN KEY FK_22AB6F1B6D0ABA22');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499933F192FC');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_603499939DEA3983');
        $this->addSql('ALTER TABLE departements DROP FOREIGN KEY FK_CF7489B298260155');
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB2507ED82115');
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB2506D0ABA22');
        $this->addSql('ALTER TABLE emargement DROP FOREIGN KEY FK_71BBB25065150016');
        $this->addSql('ALTER TABLE feuille_presence DROP FOREIGN KEY FK_F19E25E96DC6ADBB');
        $this->addSql('ALTER TABLE feuille_presence DROP FOREIGN KEY FK_F19E25E93F192FC');
        $this->addSql('ALTER TABLE fichiers DROP FOREIGN KEY FK_969DB4AB12928ADB');
        $this->addSql('ALTER TABLE fichiers DROP FOREIGN KEY FK_969DB4AB9EE12A67');
        $this->addSql('ALTER TABLE justification_absence DROP FOREIGN KEY FK_AEB54F6A6D0ABA22');
        $this->addSql('ALTER TABLE justification_absence DROP FOREIGN KEY FK_AEB54F6A3F192FC');
        $this->addSql('ALTER TABLE service_departemental DROP FOREIGN KEY FK_1BEDAE86C299BCF9');
        $this->addSql('ALTER TABLE service_departemental DROP FOREIGN KEY FK_1BEDAE86CCF9E01E');
        $this->addSql('ALTER TABLE service_regional DROP FOREIGN KEY FK_33922DCF98260155');
        $this->addSql('ALTER TABLE statut_volontaire DROP FOREIGN KEY FK_CE9791629DEA3983');
        $this->addSql('DROP TABLE affectation');
        $this->addSql('DROP TABLE bilan_volontaire');
        $this->addSql('DROP TABLE bulletin_volontaire');
        $this->addSql('DROP TABLE carte_pro');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE departements');
        $this->addSql('DROP TABLE emargement');
        $this->addSql('DROP TABLE etat_temps_presence');
        $this->addSql('DROP TABLE feuille_presence');
        $this->addSql('DROP TABLE fichiers');
        $this->addSql('DROP TABLE justification_absence');
        $this->addSql('DROP TABLE poste');
        $this->addSql('DROP TABLE regions');
        $this->addSql('DROP TABLE role');
        $this->addSql('DROP TABLE service_departemental');
        $this->addSql('DROP TABLE service_regional');
        $this->addSql('DROP TABLE statut_volontaire');
        $this->addSql('DROP TABLE type_contrat');
        $this->addSql('DROP TABLE type_fichier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE volontaire');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
