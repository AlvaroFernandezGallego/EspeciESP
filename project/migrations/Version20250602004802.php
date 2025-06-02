<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250602004802 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT '(DC2Type:json)', password VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species DROP FOREIGN KEY FK_A50FF71212469DE2
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species DROP FOREIGN KEY FK_A50FF7126BF700BD
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_A50FF71212469DE2 ON species
        SQL);
        $this->addSql(<<<'SQL'
            DROP INDEX IDX_A50FF7126BF700BD ON species
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD name VARCHAR(255) NOT NULL, ADD status VARCHAR(100) NOT NULL, ADD habitat VARCHAR(100) NOT NULL, DROP category_id, DROP status_id, DROP common_name, CHANGE scientific_name scientific_name VARCHAR(255) NOT NULL, CHANGE image description LONGTEXT DEFAULT NULL
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            DROP TABLE user
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD category_id INT NOT NULL, ADD status_id INT NOT NULL, ADD common_name VARCHAR(50) DEFAULT NULL, DROP name, DROP status, DROP habitat, CHANGE scientific_name scientific_name VARCHAR(50) NOT NULL, CHANGE description image LONGTEXT DEFAULT NULL
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD CONSTRAINT FK_A50FF71212469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE species ADD CONSTRAINT FK_A50FF7126BF700BD FOREIGN KEY (status_id) REFERENCES status (id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A50FF71212469DE2 ON species (category_id)
        SQL);
        $this->addSql(<<<'SQL'
            CREATE INDEX IDX_A50FF7126BF700BD ON species (status_id)
        SQL);
    }
}
