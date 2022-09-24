<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211220165758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE booking_request_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE room_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE booking_request (id INT NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, date_start TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_end TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, fio VARCHAR(255) DEFAULT NULL, tel VARCHAR(14) DEFAULT NULL, approved BOOLEAN DEFAULT NULL, id_room INT DEFAULT NULL, active BOOLEAN DEFAULT NULL, date_create TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, date_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id_user_create INT DEFAULT NULL, id_user_update INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE room (id INT NOT NULL, type VARCHAR(25) NOT NULL, description VARCHAR(255) DEFAULT NULL, active BOOLEAN NOT NULL, date_create TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, date_update TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, id_user_create INT NOT NULL, id_user_update INT DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE booking_request_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE room_id_seq CASCADE');
        $this->addSql('DROP TABLE booking_request');
        $this->addSql('DROP TABLE room');
    }
}
