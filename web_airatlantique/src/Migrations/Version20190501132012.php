<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190501132012 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, employee_id INT NOT NULL, login VARCHAR(255) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D768C03F15C (employee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE airport (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE employee (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, surname VARCHAR(255) NOT NULL, mail VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fly (id INT AUTO_INCREMENT NOT NULL, trip_used_id INT NOT NULL, hour_start DATETIME NOT NULL, hour_end DATETIME NOT NULL, INDEX IDX_538A83B3E4F09E7B (trip_used_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE incident (id INT AUTO_INCREMENT NOT NULL, plane_id INT NOT NULL, report LONGTEXT NOT NULL, report_date DATETIME NOT NULL, libelle VARCHAR(255) NOT NULL, INDEX IDX_3D03A11AF53666A8 (plane_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journey (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE journey_fly (journey_id INT NOT NULL, fly_id INT NOT NULL, INDEX IDX_E5865E60D5C9896F (journey_id), INDEX IDX_E5865E60BC9A249C (fly_id), PRIMARY KEY(journey_id, fly_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance (id INT AUTO_INCREMENT NOT NULL, incident_id INT NOT NULL, start_date DATETIME NOT NULL, end_date DATETIME NOT NULL, planned_date DATETIME NOT NULL, UNIQUE INDEX UNIQ_2F84F8E959E53FB9 (incident_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE maintenance_employee (maintenance_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_43E7718CF6C202BC (maintenance_id), INDEX IDX_43E7718C8C03F15C (employee_id), PRIMARY KEY(maintenance_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plane (id INT AUTO_INCREMENT NOT NULL, libelle_id INT NOT NULL, INDEX IDX_C1B32D8025DD318D (libelle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE state (id INT AUTO_INCREMENT NOT NULL, libelle VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ticket (id INT AUTO_INCREMENT NOT NULL, owner_id INT NOT NULL, journey_id INT NOT NULL, INDEX IDX_97A0ADA37E3C61F9 (owner_id), UNIQUE INDEX UNIQ_97A0ADA3D5C9896F (journey_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trip (id INT AUTO_INCREMENT NOT NULL, airport_start_id INT NOT NULL, airport_end_id INT NOT NULL, INDEX IDX_7656F53B57F59B5F (airport_start_id), INDEX IDX_7656F53B2F1D139F (airport_end_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D768C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id)');
        $this->addSql('ALTER TABLE fly ADD CONSTRAINT FK_538A83B3E4F09E7B FOREIGN KEY (trip_used_id) REFERENCES trip (id)');
        $this->addSql('ALTER TABLE incident ADD CONSTRAINT FK_3D03A11AF53666A8 FOREIGN KEY (plane_id) REFERENCES plane (id)');
        $this->addSql('ALTER TABLE journey_fly ADD CONSTRAINT FK_E5865E60D5C9896F FOREIGN KEY (journey_id) REFERENCES journey (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE journey_fly ADD CONSTRAINT FK_E5865E60BC9A249C FOREIGN KEY (fly_id) REFERENCES fly (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance ADD CONSTRAINT FK_2F84F8E959E53FB9 FOREIGN KEY (incident_id) REFERENCES incident (id)');
        $this->addSql('ALTER TABLE maintenance_employee ADD CONSTRAINT FK_43E7718CF6C202BC FOREIGN KEY (maintenance_id) REFERENCES maintenance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE maintenance_employee ADD CONSTRAINT FK_43E7718C8C03F15C FOREIGN KEY (employee_id) REFERENCES employee (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE plane ADD CONSTRAINT FK_C1B32D8025DD318D FOREIGN KEY (libelle_id) REFERENCES state (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA37E3C61F9 FOREIGN KEY (owner_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE ticket ADD CONSTRAINT FK_97A0ADA3D5C9896F FOREIGN KEY (journey_id) REFERENCES journey (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B57F59B5F FOREIGN KEY (airport_start_id) REFERENCES airport (id)');
        $this->addSql('ALTER TABLE trip ADD CONSTRAINT FK_7656F53B2F1D139F FOREIGN KEY (airport_end_id) REFERENCES airport (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B57F59B5F');
        $this->addSql('ALTER TABLE trip DROP FOREIGN KEY FK_7656F53B2F1D139F');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D768C03F15C');
        $this->addSql('ALTER TABLE maintenance_employee DROP FOREIGN KEY FK_43E7718C8C03F15C');
        $this->addSql('ALTER TABLE journey_fly DROP FOREIGN KEY FK_E5865E60BC9A249C');
        $this->addSql('ALTER TABLE maintenance DROP FOREIGN KEY FK_2F84F8E959E53FB9');
        $this->addSql('ALTER TABLE journey_fly DROP FOREIGN KEY FK_E5865E60D5C9896F');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA3D5C9896F');
        $this->addSql('ALTER TABLE maintenance_employee DROP FOREIGN KEY FK_43E7718CF6C202BC');
        $this->addSql('ALTER TABLE incident DROP FOREIGN KEY FK_3D03A11AF53666A8');
        $this->addSql('ALTER TABLE plane DROP FOREIGN KEY FK_C1B32D8025DD318D');
        $this->addSql('ALTER TABLE fly DROP FOREIGN KEY FK_538A83B3E4F09E7B');
        $this->addSql('ALTER TABLE ticket DROP FOREIGN KEY FK_97A0ADA37E3C61F9');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE airport');
        $this->addSql('DROP TABLE employee');
        $this->addSql('DROP TABLE fly');
        $this->addSql('DROP TABLE incident');
        $this->addSql('DROP TABLE journey');
        $this->addSql('DROP TABLE journey_fly');
        $this->addSql('DROP TABLE maintenance');
        $this->addSql('DROP TABLE maintenance_employee');
        $this->addSql('DROP TABLE plane');
        $this->addSql('DROP TABLE state');
        $this->addSql('DROP TABLE ticket');
        $this->addSql('DROP TABLE trip');
        $this->addSql('DROP TABLE user');
    }
}
