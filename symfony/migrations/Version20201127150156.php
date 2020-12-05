<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201127150156 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE Universities (univ_id INT AUTO_INCREMENT NOT NULL, univ_name VARCHAR(255) NOT NULL, univ_availablePlaces INT NOT NULL, univ_favorites INT NOT NULL, univ_language VARCHAR(255) NOT NULL, PRIMARY KEY(univ_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE Users (user_id INT AUTO_INCREMENT NOT NULL, user_lastName VARCHAR(255) NOT NULL, user_firstName VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, user_password VARCHAR(1000) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE Universities');
        $this->addSql('DROP TABLE Users');
    }
}
