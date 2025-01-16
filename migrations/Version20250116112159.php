<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116112159 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Tip-Material';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material ADD tip_id INT NOT NULL');
        $this->addSql('ALTER TABLE material ADD CONSTRAINT FK_7CBE7595476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id)');
        $this->addSql('CREATE INDEX IDX_7CBE7595476C47F6 ON material (tip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE material DROP FOREIGN KEY FK_7CBE7595476C47F6');
        $this->addSql('DROP INDEX IDX_7CBE7595476C47F6 ON material');
        $this->addSql('ALTER TABLE material DROP tip_id');
    }
}
