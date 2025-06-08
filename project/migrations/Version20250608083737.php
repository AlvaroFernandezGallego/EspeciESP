<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250608083737 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_880E0D76F85E0677 (username), UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE categories (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE messages (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, issue VARCHAR(50) NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_read TINYINT(1) DEFAULT 0 NOT NULL, INDEX IDX_DB021E96A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE organizations (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(50) NOT NULL, address VARCHAR(100) NOT NULL, phone_number VARCHAR(100) NOT NULL, website_url LONGTEXT NOT NULL, email VARCHAR(100) NOT NULL, INDEX IDX_427C1C7F98260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE regions (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE species (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, status_id INT NOT NULL, scientific_name VARCHAR(255) NOT NULL, common_name VARCHAR(255) DEFAULT NULL, image LONGTEXT DEFAULT NULL, INDEX IDX_A50FF71212469DE2 (category_id), INDEX IDX_A50FF7126BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE users (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(50) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)', is_banned TINYINT(1) DEFAULT 0 NOT NULL, UNIQUE INDEX UNIQ_1483A5E9F85E0677 (username), UNIQUE INDEX UNIQ_1483A5E9E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE messages ADD CONSTRAINT FK_DB021E96A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organizations ADD CONSTRAINT FK_427C1C7F98260155 FOREIGN KEY (region_id) REFERENCES regions (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD CONSTRAINT FK_A50FF71212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD CONSTRAINT FK_A50FF7126BF700BD FOREIGN KEY (status_id) REFERENCES status (id)
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE messages DROP FOREIGN KEY FK_DB021E96A76ED395
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE organizations DROP FOREIGN KEY FK_427C1C7F98260155
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species DROP FOREIGN KEY FK_A50FF71212469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species DROP FOREIGN KEY FK_A50FF7126BF700BD
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE admin
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categories
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE messages
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE organizations
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE regions
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE species
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE status
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE users
        SQL);
    }
}
