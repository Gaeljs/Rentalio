<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230515173439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993F9C41DCF');
        $this->addSql('DROP INDEX IDX_60349993F9C41DCF ON contrat');
        $this->addSql('ALTER TABLE contrat DROP locataire_id_id');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993D8A38199 FOREIGN KEY (locataire_id) REFERENCES locataire (id)');
        $this->addSql('CREATE INDEX IDX_60349993D8A38199 ON contrat (locataire_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contrat DROP FOREIGN KEY FK_60349993D8A38199');
        $this->addSql('DROP INDEX IDX_60349993D8A38199 ON contrat');
        $this->addSql('ALTER TABLE contrat ADD locataire_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE contrat ADD CONSTRAINT FK_60349993F9C41DCF FOREIGN KEY (locataire_id_id) REFERENCES locataire (id)');
        $this->addSql('CREATE INDEX IDX_60349993F9C41DCF ON contrat (locataire_id_id)');
    }
}
