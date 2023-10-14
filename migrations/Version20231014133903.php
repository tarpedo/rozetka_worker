<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231014133903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add column rozetka_accounts.market_id and rozetka_accounts.market_title';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            ALTER TABLE rozetka_accounts
                ADD market_id    INT          NOT NULL,
                ADD market_title VARCHAR(250) NOT NULL,
                CHANGE update_date update_date DATETIME NOT NULL COMMENT "(DC2Type:datetime_immutable)"
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
