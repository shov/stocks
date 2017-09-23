<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

class Version20170923155014 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql("CREATE TABLE stock (
            intProductDataId INT(10) UNSIGNED AUTO_INCREMENT NOT NULL,
            strProductName VARCHAR(50) NOT NULL,
            strProductDesc VARCHAR(255) NOT NULL,
            strProductCode VARCHAR(10) NOT NULL,
            dtmAdded DATETIME DEFAULT NULL,
            dtmDiscontinued DATETIME DEFAULT NULL,
            stmTimestamp timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE INDEX UNIQ_4B36566062F10A58 (strProductCode),
            PRIMARY KEY(intProductDataId)
        ) DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci ENGINE = InnoDB COMMENT='Stores product data'");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE stock');
    }
}
