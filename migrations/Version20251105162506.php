<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251105162506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cours (id SERIAL NOT NULL, prof_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, file_path VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CABC1F7FE ON cours (prof_id)');
        $this->addSql('COMMENT ON COLUMN cours.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CABC1F7FE FOREIGN KEY (prof_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CABC1F7FE');
        $this->addSql('DROP TABLE cours');
    }
}
