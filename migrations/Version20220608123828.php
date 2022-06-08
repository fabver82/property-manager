<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220608123828 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page ADD banner_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE page ADD CONSTRAINT FK_140AB620684EC833 FOREIGN KEY (banner_id) REFERENCES picture (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_140AB620684EC833 ON page (banner_id)');
        $this->addSql('ALTER TABLE picture ADD section_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89D823E37A FOREIGN KEY (section_id) REFERENCES page (id)');
        $this->addSql('CREATE INDEX IDX_16DB4F89D823E37A ON picture (section_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE page DROP FOREIGN KEY FK_140AB620684EC833');
        $this->addSql('DROP INDEX UNIQ_140AB620684EC833 ON page');
        $this->addSql('ALTER TABLE page DROP banner_id');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89D823E37A');
        $this->addSql('DROP INDEX IDX_16DB4F89D823E37A ON picture');
        $this->addSql('ALTER TABLE picture DROP section_id');
    }
}
