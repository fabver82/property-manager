<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220531103151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE settings (id INT AUTO_INCREMENT NOT NULL, logo VARCHAR(255) DEFAULT NULL, landing_title VARCHAR(50) DEFAULT NULL, landing_text VARCHAR(255) DEFAULT NULL, social_fb VARCHAR(255) DEFAULT NULL, social_twitter VARCHAR(255) DEFAULT NULL, social_linked_in VARCHAR(255) DEFAULT NULL, social_insta VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE picture ADD landing_slider_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F8931373C18 FOREIGN KEY (landing_slider_id) REFERENCES settings (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F8931373C18 ON picture (landing_slider_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F8931373C18');
        $this->addSql('DROP TABLE settings');
        $this->addSql('DROP INDEX IDX_16DB4F8931373C18 ON picture');
        $this->addSql('ALTER TABLE picture DROP landing_slider_id');
    }
}
