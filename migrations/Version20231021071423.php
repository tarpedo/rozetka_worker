<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20231021071423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add table rozetka_goods';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            <<<MYSQL
            CREATE TABLE rozetka_goods
            (
                rz_item_id        INT          NOT NULL,
                name              VARCHAR(255) NOT NULL,
                url               VARCHAR(400) NOT NULL,
                price             INT          NOT NULL,
                price_old         INT          NOT NULL,
                update_date       DATETIME     NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                create_date       DATETIME     NOT NULL COMMENT '(DC2Type:datetime_immutable)',
                rz_category_id    INT          DEFAULT NULL,
                rz_category_title VARCHAR(250) DEFAULT NULL,
                PRIMARY KEY (rz_item_id)
            ) DEFAULT CHARACTER SET utf8mb4
              COLLATE `utf8mb4_unicode_ci`
              ENGINE = InnoDB
            MYSQL
        );
    }

    public function down(Schema $schema): void
    {
    }
}
