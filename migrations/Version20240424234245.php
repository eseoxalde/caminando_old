<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424234245 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pagina DROP galeria, DROP video, DROP links_tipo1, DROP links_tipo2, DROP links_tipo3, DROP imagen, DROP galeria_tipo2');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pagina ADD galeria LONGTEXT DEFAULT NULL, ADD video VARCHAR(255) DEFAULT NULL, ADD links_tipo1 VARCHAR(255) DEFAULT NULL, ADD links_tipo2 VARCHAR(255) DEFAULT NULL, ADD links_tipo3 VARCHAR(255) DEFAULT NULL, ADD imagen VARCHAR(255) DEFAULT NULL, ADD galeria_tipo2 VARCHAR(255) DEFAULT NULL');
    }
}
