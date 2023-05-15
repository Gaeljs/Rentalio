<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413172331 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles TEXT NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, frais DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_64C19AA9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        // $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, frais DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_64C19AA9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contrat (id INT AUTO_INCREMENT NOT NULL, locataire_id_id INT NOT NULL, logement_id_id INT NOT NULL, INDEX IDX_60349993F9C41DCF (locataire_id_id), INDEX IDX_60349993884C09A7 (logement_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE etat_des_lieux (id INT AUTO_INCREMENT NOT NULL, contrat_id_id INT NOT NULL, date DATE NOT NULL, remarques VARCHAR(500) NOT NULL, type VARCHAR(30) NOT NULL, INDEX IDX_F72103128506F791 (contrat_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE locataire (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone VARCHAR(10) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logement (id INT AUTO_INCREMENT NOT NULL, agence_id_id INT NOT NULL, adresse VARCHAR(255) NOT NULL, complement VARCHAR(60) DEFAULT NULL, ville VARCHAR(255) NOT NULL, code_postal VARCHAR(5) NOT NULL, montant_loyer NUMERIC(10, 2) NOT NULL, charges NUMERIC(10, 2) NOT NULL, montant_depot_garantie NUMERIC(10, 2) NOT NULL, gestion TINYINT(1) NOT NULL, INDEX IDX_F0FD4457D1F6E7C3 (agence_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paiement (id INT AUTO_INCREMENT NOT NULL, contrat_id_id INT NOT NULL, montant NUMERIC(10, 2) NOT NULL, date DATE NOT NULL, source VARCHAR(30) NOT NULL, type VARCHAR(30) NOT NULL, INDEX IDX_B1DC7A1E8506F791 (contrat_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993F9C41DCF FOREIGN KEY (locataire_id_id) REFERENCES locataire (id)');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993884C09A7 FOREIGN KEY (logement_id_id) REFERENCES logement (id)');
        $this->addSql('ALTER TABLE etat_des_lieux ADD CONSTRAINT FK_F72103128506F791 FOREIGN KEY (contrat_id_id) REFERENCES contrat (id)');
        $this->addSql('ALTER TABLE logement ADD CONSTRAINT FK_F0FD4457D1F6E7C3 FOREIGN KEY (agence_id_id) REFERENCES agence (id)');
        $this->addSql('ALTER TABLE paiement ADD CONSTRAINT FK_B1DC7A1E8506F791 FOREIGN KEY (contrat_id_id) REFERENCES contrat (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993F9C41DCF');
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993884C09A7');
        $this->addSql('ALTER TABLE etat_des_lieux DROP FOREIGN KEY FK_F72103128506F791');
        $this->addSql('ALTER TABLE logement DROP FOREIGN KEY FK_F0FD4457D1F6E7C3');
        $this->addSql('ALTER TABLE paiement DROP FOREIGN KEY FK_B1DC7A1E8506F791');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE contrat');
        $this->addSql('DROP TABLE etat_des_lieux');
        $this->addSql('DROP TABLE locataire');
        $this->addSql('DROP TABLE logement');
        $this->addSql('DROP TABLE paiement');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
