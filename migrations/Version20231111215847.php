<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231111215847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table kernel_registry';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<MYSQL
        CREATE TABLE kernel_registry
        (
            `key`       VARCHAR(255) NOT NULL,
            value       VARCHAR(255) NOT NULL,
            update_date DATETIME     NOT NULL COMMENT "(DC2Type:datetime_immutable)",
            create_date DATETIME     NOT NULL COMMENT "(DC2Type:datetime_immutable)",
            PRIMARY KEY (`key`)
        ) DEFAULT CHARACTER SET utf8mb4
          COLLATE `utf8mb4_unicode_ci`
          ENGINE = InnoDB;
        MYSQL);
    }

    public function down(Schema $schema): void
    {
    }
}
