<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20160324151907 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP INDEX UNIQ_5A8A6C8D12469DE2, ADD INDEX IDX_5A8A6C8D12469DE2 (category_id)');
        $this->addSql('ALTER TABLE post CHANGE category_id category_id INT NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE post DROP INDEX IDX_5A8A6C8D12469DE2, ADD UNIQUE INDEX UNIQ_5A8A6C8D12469DE2 (category_id)');
        $this->addSql('ALTER TABLE post CHANGE category_id category_id INT DEFAULT NULL');
    }
}
