<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250916073223 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE doyenne (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_67E2BA5CDE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paroisse (id INT AUTO_INCREMENT NOT NULL, doyenne_id INT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_9068949C53C9D7E5 (doyenne_id), INDEX IDX_9068949CDE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id INT AUTO_INCREMENT NOT NULL, doyenne_id INT NOT NULL, paroisse_id INT NOT NULL, sector_id INT NOT NULL, gender VARCHAR(10) NOT NULL, phone_number VARCHAR(20) NOT NULL, full_name VARCHAR(255) NOT NULL, is_noyau TINYINT(1) NOT NULL, is_decanal TINYINT(1) NOT NULL, is_dicoces TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_34DCD17653C9D7E5 (doyenne_id), INDEX IDX_34DCD176C40C2240 (paroisse_id), INDEX IDX_34DCD176DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4BA3D9E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, person_id INT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE doyenne ADD CONSTRAINT FK_67E2BA5CDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE paroisse ADD CONSTRAINT FK_9068949C53C9D7E5 FOREIGN KEY (doyenne_id) REFERENCES doyenne (id)');
        $this->addSql('ALTER TABLE paroisse ADD CONSTRAINT FK_9068949CDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17653C9D7E5 FOREIGN KEY (doyenne_id) REFERENCES doyenne (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176C40C2240 FOREIGN KEY (paroisse_id) REFERENCES paroisse (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE doyenne DROP FOREIGN KEY FK_67E2BA5CDE95C867');
        $this->addSql('ALTER TABLE paroisse DROP FOREIGN KEY FK_9068949C53C9D7E5');
        $this->addSql('ALTER TABLE paroisse DROP FOREIGN KEY FK_9068949CDE95C867');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17653C9D7E5');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176C40C2240');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176DE95C867');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649217BBB47');
        $this->addSql('DROP TABLE doyenne');
        $this->addSql('DROP TABLE paroisse');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE user');
    }
}
