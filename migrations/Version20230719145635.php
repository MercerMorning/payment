<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230719145635 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coupon ALTER value TYPE NUMERIC(5, 2)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_64BF3F021D775834 ON coupon (value)');
        $this->addSql('ALTER TABLE product ALTER price TYPE NUMERIC(5, 2)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP INDEX UNIQ_64BF3F021D775834');
        $this->addSql('ALTER TABLE coupon ALTER value TYPE DOUBLE PRECISION');
        $this->addSql('ALTER TABLE product ALTER price TYPE DOUBLE PRECISION');
    }
}
