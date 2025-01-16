<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116113407 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Tip-Step';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step ADD tip_id INT NOT NULL');
        $this->addSql('ALTER TABLE step ADD CONSTRAINT FK_43B9FE3C476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id)');
        $this->addSql('CREATE INDEX IDX_43B9FE3C476C47F6 ON step (tip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE step DROP FOREIGN KEY FK_43B9FE3C476C47F6');
        $this->addSql('DROP INDEX IDX_43B9FE3C476C47F6 ON step');
        $this->addSql('ALTER TABLE step DROP tip_id');
    }
}
