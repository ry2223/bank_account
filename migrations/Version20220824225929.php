<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824225929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client DROP deposit, DROP withdrawal');
        $this->addSql('ALTER TABLE money CHANGE money_withdrawal money_withdrawal NUMERIC(10, 2) DEFAULT NULL, CHANGE money_deposit money_deposit NUMERIC(10, 2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE client ADD deposit NUMERIC(10, 2) DEFAULT NULL, ADD withdrawal NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE money CHANGE money_deposit money_deposit VARCHAR(255) DEFAULT NULL, CHANGE money_withdrawal money_withdrawal VARCHAR(255) DEFAULT NULL');
    }
}
