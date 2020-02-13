<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200213220754 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE format (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE episode ADD format_id INT NOT NULL, DROP format');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDA1672336E FOREIGN KEY (voice_id) REFERENCES voice (id)');
        $this->addSql('ALTER TABLE episode ADD CONSTRAINT FK_DDAA1CDAD629F605 FOREIGN KEY (format_id) REFERENCES format (id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDA1672336E ON episode (voice_id)');
        $this->addSql('CREATE INDEX IDX_DDAA1CDAD629F605 ON episode (format_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDAD629F605');
        $this->addSql('DROP TABLE format');
        $this->addSql('ALTER TABLE episode DROP FOREIGN KEY FK_DDAA1CDA1672336E');
        $this->addSql('DROP INDEX IDX_DDAA1CDA1672336E ON episode');
        $this->addSql('DROP INDEX IDX_DDAA1CDAD629F605 ON episode');
        $this->addSql('ALTER TABLE episode ADD format VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, DROP format_id');
    }
}
