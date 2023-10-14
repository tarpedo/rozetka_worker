<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231013143335 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add columns `rozetka_accounts`.`update_date` and `rozetka_accounts`.`create_date`';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            ALTER TABLE rozetka_accounts
                ADD update_date DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)",
                ADD create_date DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)"
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
