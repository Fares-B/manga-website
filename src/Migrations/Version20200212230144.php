<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200212230144 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anime (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, status_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published SMALLINT NOT NULL, kind LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', alternative_title VARCHAR(255) DEFAULT NULL, author VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_13045942C54C8C93 (type_id), INDEX IDX_130459426BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, voice VARCHAR(255) NOT NULL, season SMALLINT NOT NULL, episode SMALLINT NOT NULL, format VARCHAR(255) NOT NULL, video LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_DDAA1CDA989D9B62 (slug), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kind (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_130459426BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_130459426BF700BD');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942C54C8C93');
        $this->addSql('DROP TABLE anime');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE kind');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
    }
}
