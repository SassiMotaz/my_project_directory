<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251106161954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE forum_post (id SERIAL NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_996BCC5AF675F31B ON forum_post (author_id)');
        $this->addSql('COMMENT ON COLUMN forum_post.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE forum_reply (id SERIAL NOT NULL, author_id INT DEFAULT NULL, post_id INT DEFAULT NULL, content TEXT NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E5DC6037F675F31B ON forum_reply (author_id)');
        $this->addSql('CREATE INDEX IDX_E5DC60374B89032C ON forum_reply (post_id)');
        $this->addSql('COMMENT ON COLUMN forum_reply.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5AF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_reply ADD CONSTRAINT FK_E5DC6037F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_reply ADD CONSTRAINT FK_E5DC60374B89032C FOREIGN KEY (post_id) REFERENCES forum_post (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE forum_post DROP CONSTRAINT FK_996BCC5AF675F31B');
        $this->addSql('ALTER TABLE forum_reply DROP CONSTRAINT FK_E5DC6037F675F31B');
        $this->addSql('ALTER TABLE forum_reply DROP CONSTRAINT FK_E5DC60374B89032C');
        $this->addSql('DROP TABLE forum_post');
        $this->addSql('DROP TABLE forum_reply');
    }
}
