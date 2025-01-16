<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116111939 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Tip-Instruction';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instruction ADD tip_id INT NOT NULL');
        $this->addSql('ALTER TABLE instruction ADD CONSTRAINT FK_7BBAE156476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id)');
        $this->addSql('CREATE INDEX IDX_7BBAE156476C47F6 ON instruction (tip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE instruction DROP FOREIGN KEY FK_7BBAE156476C47F6');
        $this->addSql('DROP INDEX IDX_7BBAE156476C47F6 ON instruction');
        $this->addSql('ALTER TABLE instruction DROP tip_id');
    }
}
