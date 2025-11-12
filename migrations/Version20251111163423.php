<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251111163423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question DROP justification');
        $this->addSql('ALTER TABLE question DROP ordre');
        $this->addSql('ALTER TABLE question ALTER texte TYPE VARCHAR(255)');
        $this->addSql('ALTER TABLE quiz RENAME COLUMN texte TO titre');
        $this->addSql('ALTER TABLE reponse ALTER texte TYPE VARCHAR(255)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE question ADD justification TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ADD ordre INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question ALTER texte TYPE TEXT');
        $this->addSql('ALTER TABLE reponse ALTER texte TYPE TEXT');
        $this->addSql('ALTER TABLE quiz RENAME COLUMN titre TO texte');
    }
}
