<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231126103534 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table admin_user';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(<<<MYSQL
        CREATE TABLE admin_user
        (
            id          INT UNSIGNED AUTO_INCREMENT NOT NULL,
            login       VARCHAR(100)                NOT NULL,
            roles       JSON                        NOT NULL,
            update_date DATETIME                    NOT NULL COMMENT '(DC2Type:datetime_immutable)',
            create_date DATETIME                    NOT NULL COMMENT '(DC2Type:datetime_immutable)',
            UNIQUE INDEX UNIQ_AD8A54A9AA08CB10 (login),
            PRIMARY KEY (id)
        ) DEFAULT CHARACTER SET utf8mb4
          COLLATE `utf8mb4_unicode_ci`
          ENGINE = InnoDB
        MYSQL);
    }

    public function down(Schema $schema): void
    {
    }
}
