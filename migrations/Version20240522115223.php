<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240522115223 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Creates instructors and training_offers tables';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE instructors (
            id INT AUTO_INCREMENT NOT NULL,
            first_name VARCHAR(256) NOT NULL,
            last_name VARCHAR(256) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE training_offers (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(512) NOT NULL,
            instructor_id INT NOT NULL,
            training_datetime DATETIME NOT NULL,
            price DECIMAL NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            PRIMARY KEY(id),
            UNIQUE INDEX UNIQ_name (name),
            INDEX IDX_training_datetime (training_datetime),
            CONSTRAINT FK_instructor_id FOREIGN KEY (instructor_id) REFERENCES instructors(id) ON DELETE CASCADE
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE training_offers');
        $this->addSql('DROP TABLE instructors');
    }
}
