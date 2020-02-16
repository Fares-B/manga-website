<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200216012952 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE anime (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, status_id INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, published SMALLINT NOT NULL, alternative_title VARCHAR(255) DEFAULT NULL, author VARCHAR(255) NOT NULL, country VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, image VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_13045942C54C8C93 (type_id), INDEX IDX_130459426BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE anime_kind (anime_id INT NOT NULL, kind_id INT NOT NULL, INDEX IDX_94316E8D794BBE89 (anime_id), INDEX IDX_94316E8D30602CA9 (kind_id), PRIMARY KEY(anime_id, kind_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE episode (id INT AUTO_INCREMENT NOT NULL, anime_id INT NOT NULL, voice_id INT NOT NULL, format_id INT NOT NULL, season SMALLINT NOT NULL, episode SMALLINT NOT NULL, video LONGTEXT NOT NULL, created_at DATETIME NOT NULL, slug VARCHAR(255) NOT NULL, INDEX IDX_DDAA1CDA794BBE89 (anime_id), INDEX IDX_DDAA1CDA1672336E (voice_id), INDEX IDX_DDAA1CDAD629F605 (format_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE kind (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE voice (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_13045942C54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE anime ADD CONSTRAINT FK_130459426BF700BD FOREIGN KEY (status_id) REFERENCES status (id)');
        $this->addSql('ALTER TABLE anime_kind ADD CONSTRAINT FK_94316E8D794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE anime_kind ADD CONSTRAINT FK_94316E8D30602CA9 FOREIGN KEY (kind_id) REFERENCES kind (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA794BBE89 FOREIGN KEY (anime_id) REFERENCES anime (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA1672336E FOREIGN KEY (voice_id) REFERENCES voice (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAD629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE anime_kind DROP FOREIGN KEY FK_94316E8D794BBE89');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA794BBE89');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAD629F605');
        $this->addSql('ALTER TABLE anime_kind DROP FOREIGN KEY FK_94316E8D30602CA9');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_130459426BF700BD');
        $this->addSql('ALTER TABLE anime DROP FOREIGN KEY FK_13045942C54C8C93');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA1672336E');
        $this->addSql('DROP TABLE anime');
        $this->addSql('DROP TABLE anime_kind');
        $this->addSql('DROP TABLE episode');
        $this->addSql('DROP TABLE format');
        $this->addSql('DROP TABLE kind');
        $this->addSql('DROP TABLE status');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE voice');
    }
}
