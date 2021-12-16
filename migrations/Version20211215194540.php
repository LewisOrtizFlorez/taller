<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211215194540 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        
        $this->addSql("INSERT INTO role (id, name, created_at, updated_at) VALUES (nextval('role_id_seq'), 'Patient', NOW(), NOW())");
        $this->addSql("INSERT INTO role (id, name, created_at, updated_at) VALUES (nextval('role_id_seq'), 'Admin', NOW(), NOW())");
        $this->addSql("INSERT INTO role (id, name, created_at, updated_at) VALUES (nextval('role_id_seq'), 'Technologist', NOW(), NOW())");
        $this->addSql("INSERT INTO role (id, name, created_at, updated_at) VALUES (nextval('role_id_seq'), 'Radiologist', NOW(), NOW())");
        $this->addSql("INSERT INTO role (id, name, created_at, updated_at) VALUES (nextval('role_id_seq'), 'Receptionist', NOW(), NOW())");

    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
    }
}
