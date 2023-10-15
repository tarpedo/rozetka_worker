<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231015142132 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Move columns';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            ALTER TABLE `rozetka_accounts`
                CHANGE COLUMN `update_date` `update_date` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)' AFTER `market_title`,
                CHANGE COLUMN `create_date` `create_date` DATETIME NOT NULL COMMENT '(DC2Type:datetime_immutable)' AFTER `update_date`;
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
