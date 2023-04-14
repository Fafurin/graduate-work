<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230413102710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE book_format_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE book_format (id INT NOT NULL, title VARCHAR(255) NOT NULL, size VARCHAR(255) NOT NULL, is_deleted BOOLEAN NOT NULL, slug VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F76D79522B36786B ON book_format (title)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F76D7952F7C0246A ON book_format (size)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_F76D7952989D9B62 ON book_format (slug)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_95431C21989D9B62 ON book_type (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE book_format_id_seq CASCADE');
        $this->addSql('DROP TABLE book_format');
        $this->addSql('DROP INDEX UNIQ_95431C21989D9B62');
    }
}
