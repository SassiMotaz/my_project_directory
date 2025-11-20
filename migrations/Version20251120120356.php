<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251120120356 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT FK_FDCA8C9CABC1F7FE');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CABC1F7FE FOREIGN KEY (prof_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_post DROP CONSTRAINT FK_996BCC5AF675F31B');
        $this->addSql('ALTER TABLE forum_post ALTER author_id SET NOT NULL');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT FK_996BCC5AF675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_reply DROP CONSTRAINT FK_E5DC6037F675F31B');
        $this->addSql('ALTER TABLE forum_reply ALTER author_id SET NOT NULL');
        $this->addSql('ALTER TABLE forum_reply ADD CONSTRAINT FK_E5DC6037F675F31B FOREIGN KEY (author_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE forum_reply DROP CONSTRAINT fk_e5dc6037f675f31b');
        $this->addSql('ALTER TABLE forum_reply ALTER author_id DROP NOT NULL');
        $this->addSql('ALTER TABLE forum_reply ADD CONSTRAINT fk_e5dc6037f675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE cours DROP CONSTRAINT fk_fdca8c9cabc1f7fe');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT fk_fdca8c9cabc1f7fe FOREIGN KEY (prof_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE forum_post DROP CONSTRAINT fk_996bcc5af675f31b');
        $this->addSql('ALTER TABLE forum_post ALTER author_id DROP NOT NULL');
        $this->addSql('ALTER TABLE forum_post ADD CONSTRAINT fk_996bcc5af675f31b FOREIGN KEY (author_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }
}
