<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240316205233 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE sitio DROP FOREIGN KEY FK_4B4B92084A0A3ED');
        $this->addSql('DROP TABLE sitio_pagina');
        $this->addSql('DROP INDEX IDX_4B4B92084A0A3ED ON sitio');
        $this->addSql('ALTER TABLE sitio DROP content_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE sitio_pagina (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE sitio ADD content_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE sitio ADD CONSTRAINT FK_4B4B92084A0A3ED FOREIGN KEY (content_id) REFERENCES sitio_pagina (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_4B4B92084A0A3ED ON sitio (content_id)');
    }
}
