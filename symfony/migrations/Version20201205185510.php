<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201205185510 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE favorites (users_id INT NOT NULL, universities_id INT NOT NULL, INDEX IDX_B02443D267B3B43D (users_id), INDEX IDX_B02443D2B46E2353 (universities_id), PRIMARY KEY(users_id, universities_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_B02443D267B3B43D FOREIGN KEY (users_id) REFERENCES Users (user_id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE favorites ADD CONSTRAINT FK_B02443D2B46E2353 FOREIGN KEY (universities_id) REFERENCES Universities (univ_id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE favorites');
    }
}
