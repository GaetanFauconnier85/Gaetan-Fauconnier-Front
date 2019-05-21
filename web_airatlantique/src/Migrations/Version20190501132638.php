<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190501132638 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fly ADD plane_id INT NOT NULL');
        $this->addSql('ALTER TABLE fly ADD CONSTRAINT FK_538A83B3F53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id)');
        $this->addSql('CREATE INDEX IDX_538A83B3F53666A8 ON fly (plane_id)');
        $this->addSql('ALTER TABLE user ADD name VARCHAR(255) NOT NULL, ADD surname VARCHAR(255) NOT NULL, ADD birthdate DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fly DROP FOREIGN KEY FK_538A83B3F53666A8');
        $this->addSql('DROP INDEX IDX_538A83B3F53666A8 ON fly');
        $this->addSql('ALTER TABLE fly DROP plane_id');
        $this->addSql('ALTER TABLE user DROP name, DROP surname, DROP birthdate');
    }
}
