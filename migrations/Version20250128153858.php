<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250128153858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Relation Tip-User';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE tip ADD CONSTRAINT FK_4883B84CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4883B84CA76ED395 ON tip (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tip DROP FOREIGN KEY FK_4883B84CA76ED395');
        $this->addSql('DROP INDEX IDX_4883B84CA76ED395 ON tip');
        $this->addSql('ALTER TABLE tip DROP user_id');
    }
}
