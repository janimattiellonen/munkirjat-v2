<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
    Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130206002435 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(45) NOT NULL, lastname VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, language_id VARCHAR(3) NOT NULL, page_count INT NOT NULL, is_read INT NOT NULL, isbn VARCHAR(40) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, started_reading DATETIME NOT NULL, finished_reading DATETIME NOT NULL, rating DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE book_author (book_id INT NOT NULL, author_id INT NOT NULL, INDEX IDX_9478D34516A2B381 (book_id), INDEX IDX_9478D345F675F31B (author_id), PRIMARY KEY(book_id, author_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE book_genre (book_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_8D92268116A2B381 (book_id), INDEX IDX_8D9226814296D31F (genre_id), PRIMARY KEY(book_id, genre_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE book_tag (book_id INT NOT NULL, tag_id INT NOT NULL, INDEX IDX_F2F4CE1516A2B381 (book_id), INDEX IDX_F2F4CE15BAD26311 (tag_id), PRIMARY KEY(book_id, tag_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE genre (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("CREATE TABLE tag (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(45) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE book_author ADD CONSTRAINT FK_9478D34516A2B381 FOREIGN KEY (book_id) REFERENCES book (id)");
        $this->addSql("ALTER TABLE book_author ADD CONSTRAINT FK_9478D345F675F31B FOREIGN KEY (author_id) REFERENCES author (id)");
        $this->addSql("ALTER TABLE book_genre ADD CONSTRAINT FK_8D92268116A2B381 FOREIGN KEY (book_id) REFERENCES book (id)");
        $this->addSql("ALTER TABLE book_genre ADD CONSTRAINT FK_8D9226814296D31F FOREIGN KEY (genre_id) REFERENCES genre (id)");
        $this->addSql("ALTER TABLE book_tag ADD CONSTRAINT FK_F2F4CE1516A2B381 FOREIGN KEY (book_id) REFERENCES book (id)");
        $this->addSql("ALTER TABLE book_tag ADD CONSTRAINT FK_F2F4CE15BAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id)");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("ALTER TABLE book_author DROP FOREIGN KEY FK_9478D345F675F31B");
        $this->addSql("ALTER TABLE book_author DROP FOREIGN KEY FK_9478D34516A2B381");
        $this->addSql("ALTER TABLE book_genre DROP FOREIGN KEY FK_8D92268116A2B381");
        $this->addSql("ALTER TABLE book_tag DROP FOREIGN KEY FK_F2F4CE1516A2B381");
        $this->addSql("ALTER TABLE book_genre DROP FOREIGN KEY FK_8D9226814296D31F");
        $this->addSql("ALTER TABLE book_tag DROP FOREIGN KEY FK_F2F4CE15BAD26311");
        $this->addSql("DROP TABLE author");
        $this->addSql("DROP TABLE book");
        $this->addSql("DROP TABLE book_author");
        $this->addSql("DROP TABLE book_genre");
        $this->addSql("DROP TABLE book_tag");
        $this->addSql("DROP TABLE genre");
        $this->addSql("DROP TABLE tag");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6");
        $this->addSql("ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id)");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id)");
        $this->addSql("ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id)");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id)");
        $this->addSql("ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id)");
    }
}
