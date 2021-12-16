<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211216185603 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE patient ADD person_contact_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE patient ADD CONSTRAINT FK_1ADAD7EBD11A465F FOREIGN KEY (person_contact_id) REFERENCES person_contact (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1ADAD7EBD11A465F ON patient (person_contact_id)');
        $this->addSql('ALTER TABLE person_contact DROP CONSTRAINT fk_6efc55b16b899279');
        $this->addSql('DROP INDEX uniq_6efc55b16b899279');
        $this->addSql('ALTER TABLE person_contact DROP patient_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE person_contact ADD patient_id INT NOT NULL');
        $this->addSql('ALTER TABLE person_contact ADD CONSTRAINT fk_6efc55b16b899279 FOREIGN KEY (patient_id) REFERENCES patient (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX uniq_6efc55b16b899279 ON person_contact (patient_id)');
        $this->addSql('ALTER TABLE patient DROP CONSTRAINT FK_1ADAD7EBD11A465F');
        $this->addSql('DROP INDEX UNIQ_1ADAD7EBD11A465F');
        $this->addSql('ALTER TABLE patient DROP person_contact_id');
    }
}
