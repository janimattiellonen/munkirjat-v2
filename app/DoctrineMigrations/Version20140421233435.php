<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140421233435 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE readingsession (id INT AUTO_INCREMENT NOT NULL, book_id INT DEFAULT NULL, starting_page INT DEFAULT NULL, ending_page INT DEFAULT NULL, starting_date DATETIME NOT NULL, ending_date DATETIME DEFAULT NULL, INDEX IDX_B4C9743B16A2B381 (book_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE readingsession ADD CONSTRAINT FK_B4C9743B16A2B381 FOREIGN KEY (book_id) REFERENCES book (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE readingsession");
    }
}
