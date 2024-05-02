<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240428090310 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE family_member_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE family_node_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE family_member (id INT NOT NULL, child_of_id INT DEFAULT NULL, first_name VARCHAR(100) NOT NULL, last_name VARCHAR(100) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B9D4AD6D90B01EF ON family_member (child_of_id)');
        $this->addSql('CREATE TABLE family_node (id INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE family_node_family_member (family_node_id INT NOT NULL, family_member_id INT NOT NULL, PRIMARY KEY(family_node_id, family_member_id))');
        $this->addSql('CREATE INDEX IDX_CEC5BAC32B194B6B ON family_node_family_member (family_node_id)');
        $this->addSql('CREATE INDEX IDX_CEC5BAC3BC594993 ON family_node_family_member (family_member_id)');
        $this->addSql('CREATE TABLE messenger_messages (id BIGSERIAL NOT NULL, body TEXT NOT NULL, headers TEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, available_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, delivered_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_75EA56E0FB7336F0 ON messenger_messages (queue_name)');
        $this->addSql('CREATE INDEX IDX_75EA56E0E3BD61CE ON messenger_messages (available_at)');
        $this->addSql('CREATE INDEX IDX_75EA56E016BA31DB ON messenger_messages (delivered_at)');
        $this->addSql('COMMENT ON COLUMN messenger_messages.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.available_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN messenger_messages.delivered_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE OR REPLACE FUNCTION notify_messenger_messages() RETURNS TRIGGER AS $$
            BEGIN
                PERFORM pg_notify(\'messenger_messages\', NEW.queue_name::text);
                RETURN NEW;
            END;
        $$ LANGUAGE plpgsql;');
        $this->addSql('DROP TRIGGER IF EXISTS notify_trigger ON messenger_messages;');
        $this->addSql('CREATE TRIGGER notify_trigger AFTER INSERT OR UPDATE ON messenger_messages FOR EACH ROW EXECUTE PROCEDURE notify_messenger_messages();');
        $this->addSql('ALTER TABLE family_member ADD CONSTRAINT FK_B9D4AD6D90B01EF FOREIGN KEY (child_of_id) REFERENCES family_node (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE family_node_family_member ADD CONSTRAINT FK_CEC5BAC32B194B6B FOREIGN KEY (family_node_id) REFERENCES family_node (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE family_node_family_member ADD CONSTRAINT FK_CEC5BAC3BC594993 FOREIGN KEY (family_member_id) REFERENCES family_member (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE family_member_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE family_node_id_seq CASCADE');
        $this->addSql('ALTER TABLE family_member DROP CONSTRAINT FK_B9D4AD6D90B01EF');
        $this->addSql('ALTER TABLE family_node_family_member DROP CONSTRAINT FK_CEC5BAC32B194B6B');
        $this->addSql('ALTER TABLE family_node_family_member DROP CONSTRAINT FK_CEC5BAC3BC594993');
        $this->addSql('DROP TABLE family_member');
        $this->addSql('DROP TABLE family_node');
        $this->addSql('DROP TABLE family_node_family_member');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
