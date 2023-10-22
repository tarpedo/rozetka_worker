<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231022120825 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add link between rozetka_goods.account_id and rozetka_accounts.id';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            ALTER TABLE rozetka_goods
                ADD account_id INT UNSIGNED NOT NULL;

            ALTER TABLE rozetka_goods
                ADD CONSTRAINT FK_97CF24009B6B5FBA 
                    FOREIGN KEY (account_id)
                        REFERENCES rozetka_accounts (id) ON DELETE CASCADE;

            CREATE INDEX IDX_97CF24009B6B5FBA ON rozetka_goods (account_id);
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
