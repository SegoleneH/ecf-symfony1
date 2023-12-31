<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231002102845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livre_genre (livre_id INT NOT NULL, genre_id INT NOT NULL, INDEX IDX_1053AB9E37D925CB (livre_id), INDEX IDX_1053AB9E4296D31F (genre_id), PRIMARY KEY(livre_id, genre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre ADD CONSTRAINT FK_1053AB9E4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE genre_livre');
        $this->addSql('ALTER TABLE auteur ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunt ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE emprunteur ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE genre ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE livre ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD created_at DATETIME NOT NULL, ADD updated_at DATETIME NOT NULL, ADD deleted_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE genre_livre (genre_id INT NOT NULL, livre_id INT NOT NULL, INDEX IDX_1165505C37D925CB (livre_id), INDEX IDX_1165505C4296D31F (genre_id), PRIMARY KEY(genre_id, livre_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C4296D31F FOREIGN KEY (genre_id) REFERENCES genre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE genre_livre ADD CONSTRAINT FK_1165505C37D925CB FOREIGN KEY (livre_id) REFERENCES livre (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE livre_genre DROP FOREIGN KEY FK_1053AB9E37D925CB');
        $this->addSql('ALTER TABLE livre_genre DROP FOREIGN KEY FK_1053AB9E4296D31F');
        $this->addSql('DROP TABLE livre_genre');
        $this->addSql('ALTER TABLE emprunt DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE auteur DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE emprunteur DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE livre DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE user DROP created_at, DROP updated_at, DROP deleted_at');
        $this->addSql('ALTER TABLE genre DROP created_at, DROP updated_at, DROP deleted_at');
    }
}
