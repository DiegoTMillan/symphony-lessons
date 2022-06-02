<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220602160718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE entrada_etiqueta (entrada_id INT NOT NULL, etiqueta_id INT NOT NULL, INDEX IDX_E1CFEEA4A688222A (entrada_id), INDEX IDX_E1CFEEA4D53DA3AB (etiqueta_id), PRIMARY KEY(entrada_id, etiqueta_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE entrada_etiqueta ADD CONSTRAINT FK_E1CFEEA4A688222A FOREIGN KEY (entrada_id) REFERENCES entrada (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE entrada_etiqueta ADD CONSTRAINT FK_E1CFEEA4D53DA3AB FOREIGN KEY (etiqueta_id) REFERENCES etiqueta (id) ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C949A274989D9B62 ON entrada (slug)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE entrada_etiqueta');
        $this->addSql('DROP INDEX UNIQ_C949A274989D9B62 ON entrada');
    }
}
