<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608093906 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture DROP caption');
        $this->addSql('ALTER TABLE property ADD main_picture_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE property ADD CONSTRAINT FK_8BF21CDED6BDC9DC FOREIGN KEY (main_picture_id) REFERENCES picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8BF21CDED6BDC9DC ON property (main_picture_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE picture ADD caption VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE property DROP FOREIGN KEY FK_8BF21CDED6BDC9DC');
        $this->addSql('DROP INDEX UNIQ_8BF21CDED6BDC9DC ON property');
        $this->addSql('ALTER TABLE property DROP main_picture_id');
    }
}
