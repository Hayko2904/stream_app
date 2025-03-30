<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330112933 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add card holder name to payment table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE payment ADD card_holder_name VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE payment DROP card_holder_name');
    }
}
