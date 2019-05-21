<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190501140727 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plane DROP FOREIGN KEY FK_C1B32D8025DD318D');
        $this->addSql('DROP INDEX IDX_C1B32D8025DD318D ON plane');
        $this->addSql('ALTER TABLE plane ADD libelle VARCHAR(255) NOT NULL, CHANGE libelle_id state_id INT NOT NULL');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D805D83CC1 FOREIGN KEY (state_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_C1B32D805D83CC1 ON plane (state_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE plane DROP FOREIGN KEY FK_C1B32D805D83CC1');
        $this->addSql('DROP INDEX IDX_C1B32D805D83CC1 ON plane');
        $this->addSql('ALTER TABLE plane DROP libelle, CHANGE state_id libelle_id INT NOT NULL');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D8025DD318D FOREIGN KEY (libelle_id) REFERENCES state (id)');
        $this->addSql('CREATE INDEX IDX_C1B32D8025DD318D ON plane (libelle_id)');
    }
}
