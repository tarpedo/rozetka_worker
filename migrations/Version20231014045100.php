<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231014045100 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Rename index';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
                ALTER TABLE rozetka_accounts RENAME INDEX username TO UNIQ_E1D25019F85E0677
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
