<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250330111402 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, address_line1 VARCHAR(255) NOT NULL, address_line2 VARCHAR(255) DEFAULT NULL, city VARCHAR(100) NOT NULL, postal_code VARCHAR(20) NOT NULL, state VARCHAR(100) NOT NULL, country VARCHAR(2) NOT NULL, UNIQUE INDEX UNIQ_D4E6F81A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, credit_card_number VARCHAR(16) NOT NULL, card_expiration VARCHAR(5) NOT NULL, cvv VARCHAR(3) NOT NULL, UNIQUE INDEX UNIQ_6D28840DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE address ADD CONSTRAINT FK_D4E6F81A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment ADD CONSTRAINT FK_6D28840DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user DROP address_line1, DROP address_line2, DROP city, DROP postal_code, DROP state, DROP country, DROP credit_card_number, DROP card_expiration, DROP cvv
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE payment DROP FOREIGN KEY FK_6D28840DA76ED395
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE address
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE payment
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE user ADD address_line1 VARCHAR(255) NOT NULL, ADD address_line2 VARCHAR(255) DEFAULT NULL, ADD city VARCHAR(100) NOT NULL, ADD postal_code VARCHAR(20) NOT NULL, ADD state VARCHAR(100) NOT NULL, ADD country VARCHAR(2) NOT NULL, ADD credit_card_number VARCHAR(16) DEFAULT NULL, ADD card_expiration VARCHAR(5) DEFAULT NULL, ADD cvv VARCHAR(3) DEFAULT NULL
        SQL);
    }
}
