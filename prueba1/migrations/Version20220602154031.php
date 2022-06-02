<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602154031 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE UNIQUE INDEX UNIQ_4E10122D3A909126 ON categoria (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_90BF6AA43A909126 ON espacio (nombre)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6D5CA63A3A909126 ON etiqueta (nombre)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_4E10122D3A909126 ON categoria');
        $this->addSql('DROP INDEX UNIQ_90BF6AA43A909126 ON espacio');
        $this->addSql('DROP INDEX UNIQ_6D5CA63A3A909126 ON etiqueta');
    }
}
