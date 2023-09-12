<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230912115246 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tenant (id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(64) NOT NULL, tier VARCHAR(64) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E59C4625E237E06 ON tenant (name)');
        $this->addSql('CREATE TABLE tenant_user (id INT NOT NULL, tenant_id INT NOT NULL, email VARCHAR(255) NOT NULL, given_name VARCHAR(255) NOT NULL, family_name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7FC8C9AE7927C74 ON tenant_user (email)');
        $this->addSql('CREATE INDEX IDX_C7FC8C9A9033212A ON tenant_user (tenant_id)');
        $this->addSql('ALTER TABLE tenant_user ADD CONSTRAINT FK_C7FC8C9A9033212A FOREIGN KEY (tenant_id) REFERENCES tenant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');


        $this->addSql('ALTER TABLE tenant ENABLE ROW LEVEL SECURITY');
        $this->addSql('CREATE POLICY tenant_isolation_policy ON tenant USING (id::TEXT = current_setting(\'app.current_tenant\')::TEXT)');

        $this->addSql('ALTER TABLE tenant_user ENABLE ROW LEVEL SECURITY');
        $this->addSql('CREATE POLICY tenant_user_isolation_policy ON tenant_user USING (tenant_id::TEXT = current_setting(\'app.current_tenant\')::TEXT)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP POLICY tenant_isolation_policy');
        $this->addSql('DROP POLICY tenant_user_isolation_policy');
        $this->addSql('ALTER TABLE tenant_user DROP CONSTRAINT FK_C7FC8C9A9033212A');
        $this->addSql('DROP TABLE tenant');
        $this->addSql('DROP TABLE tenant_user');
    }
}
