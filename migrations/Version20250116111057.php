<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250116111057 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quantity (id INT AUTO_INCREMENT NOT NULL, tip_id INT NOT NULL, ingredient_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, unit VARCHAR(255) NOT NULL, INDEX IDX_9FF31636476C47F6 (tip_id), INDEX IDX_9FF31636933FE08C (ingredient_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636476C47F6 FOREIGN KEY (tip_id) REFERENCES tip (id)');
        $this->addSql('ALTER TABLE quantity ADD CONSTRAINT FK_9FF31636933FE08C FOREIGN KEY (ingredient_id) REFERENCES ingredient (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636476C47F6');
        $this->addSql('ALTER TABLE quantity DROP FOREIGN KEY FK_9FF31636933FE08C');
        $this->addSql('DROP TABLE quantity');
    }
}
