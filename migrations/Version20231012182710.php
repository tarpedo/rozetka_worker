<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231012182710 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table `rozetka_accounts`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            CREATE TABLE rozetka_accounts
            (
                id           INT UNSIGNED AUTO_INCREMENT NOT NULL,
                username     VARCHAR(255)                NOT NULL,
                password     VARCHAR(255)                NOT NULL,
                seller_fio   VARCHAR(250)                NOT NULL,
                seller_email VARCHAR(250)                NOT NULL,
                UNIQUE INDEX username (username),
                PRIMARY KEY (id)
            ) DEFAULT CHARACTER SET utf8mb4
              COLLATE `utf8mb4_unicode_ci`
              ENGINE = InnoDB
            MYSQL
        );
    }

    public function down(Schema $schema): void { }
}
