<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250922090837 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE administration (id INT AUTO_INCREMENT NOT NULL, camp_biblic_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_9FDD0D1883DE392 (camp_biblic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE administration_user (administration_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1C4927A39B8E743 (administration_id), INDEX IDX_1C4927AA76ED395 (user_id), PRIMARY KEY(administration_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp_biblique (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', name VARCHAR(255) NOT NULL, start DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', location VARCHAR(255) NOT NULL, topic LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cost (id INT AUTO_INCREMENT NOT NULL, camp_biblic_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', montant_id INT DEFAULT NULL, motif LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_182694FC83DE392 (camp_biblic_id), UNIQUE INDEX UNIQ_182694FC1F8D148 (montant_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE doyenne (id INT AUTO_INCREMENT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_67E2BA5C5E237E06 (name), INDEX IDX_67E2BA5CDE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE finance (id INT AUTO_INCREMENT NOT NULL, camp_biblic_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_CE28EAE083DE392 (camp_biblic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE finance_user (finance_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_22872D495E87A6C2 (finance_id), INDEX IDX_22872D49A76ED395 (user_id), PRIMARY KEY(finance_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hebergement (id INT AUTO_INCREMENT NOT NULL, camp_biblic_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_4852DD9C83DE392 (camp_biblic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE hebergement_user (hebergement_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_47E632D423BB0F66 (hebergement_id), INDEX IDX_47E632D4A76ED395 (user_id), PRIMARY KEY(hebergement_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informatique (id INT AUTO_INCREMENT NOT NULL, camp_biblic_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', UNIQUE INDEX UNIQ_24CC943883DE392 (camp_biblic_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE informatique_user (informatique_id INT NOT NULL, user_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_1A98AD64CBC6B0B9 (informatique_id), INDEX IDX_1A98AD64A76ED395 (user_id), PRIMARY KEY(informatique_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE logistic (id INT AUTO_INCREMENT NOT NULL, cb_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', dortoir_frere INT NOT NULL, dortoir_soeur INT NOT NULL, carrefour INT NOT NULL, UNIQUE INDEX UNIQ_54BD53BD109FD92A (cb_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE montant (id INT AUTO_INCREMENT NOT NULL, participator_id INT NOT NULL, devise VARCHAR(15) NOT NULL, frais INT NOT NULL, status VARCHAR(10) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_A9F3E3288E46E9DE (participator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE montant_camp_biblique (montant_id INT NOT NULL, camp_biblique_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DDD6357C1F8D148 (montant_id), INDEX IDX_DDD6357C62CA15CB (camp_biblique_id), PRIMARY KEY(montant_id, camp_biblique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paroisse (id INT AUTO_INCREMENT NOT NULL, doyenne_id INT NOT NULL, sector_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_9068949C5E237E06 (name), INDEX IDX_9068949C53C9D7E5 (doyenne_id), INDEX IDX_9068949CDE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participator (id INT AUTO_INCREMENT NOT NULL, person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', carrefour VARCHAR(255) NOT NULL, dortoir VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', badge TINYINT(1) NOT NULL, INDEX IDX_BEE9AD38217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE participator_camp_biblique (participator_id INT NOT NULL, camp_biblique_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_9DED40DE8E46E9DE (participator_id), INDEX IDX_9DED40DE62CA15CB (camp_biblique_id), PRIMARY KEY(participator_id, camp_biblique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE person (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', doyenne_id INT NOT NULL, paroisse_id INT NOT NULL, sector_id INT NOT NULL, gender VARCHAR(10) NOT NULL, phone_number VARCHAR(20) NOT NULL, full_name VARCHAR(255) NOT NULL, is_noyau TINYINT(1) NOT NULL, is_decanal TINYINT(1) NOT NULL, is_dicoces TINYINT(1) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', UNIQUE INDEX UNIQ_34DCD1766B01BC5B (phone_number), INDEX IDX_34DCD17653C9D7E5 (doyenne_id), INDEX IDX_34DCD176C40C2240 (paroisse_id), INDEX IDX_34DCD176DE95C867 (sector_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE removal (id INT AUTO_INCREMENT NOT NULL, motif LONGTEXT NOT NULL, start DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE removal_camp_biblique (removal_id INT NOT NULL, camp_biblique_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_CFD2709BA00B94E6 (removal_id), INDEX IDX_CFD2709B62CA15CB (camp_biblique_id), PRIMARY KEY(removal_id, camp_biblique_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE removal_participator (removal_id INT NOT NULL, participator_id INT NOT NULL, INDEX IDX_C404113EA00B94E6 (removal_id), INDEX IDX_C404113E8E46E9DE (participator_id), PRIMARY KEY(removal_id, participator_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sector (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_4BA3D9E85E237E06 (name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', person_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\', username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), UNIQUE INDEX UNIQ_8D93D649217BBB47 (person_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE administration ADD CONSTRAINT FK_9FDD0D1883DE392 FOREIGN KEY (camp_biblic_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE administration_user ADD CONSTRAINT FK_1C4927A39B8E743 FOREIGN KEY (administration_id) REFERENCES administration (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE administration_user ADD CONSTRAINT FK_1C4927AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE cost ADD CONSTRAINT FK_182694FC83DE392 FOREIGN KEY (camp_biblic_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE cost ADD CONSTRAINT FK_182694FC1F8D148 FOREIGN KEY (montant_id) REFERENCES montant (id)');
        $this->addSql('ALTER TABLE doyenne ADD CONSTRAINT FK_67E2BA5CDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE finance ADD CONSTRAINT FK_CE28EAE083DE392 FOREIGN KEY (camp_biblic_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE finance_user ADD CONSTRAINT FK_22872D495E87A6C2 FOREIGN KEY (finance_id) REFERENCES finance (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE finance_user ADD CONSTRAINT FK_22872D49A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hebergement ADD CONSTRAINT FK_4852DD9C83DE392 FOREIGN KEY (camp_biblic_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE hebergement_user ADD CONSTRAINT FK_47E632D423BB0F66 FOREIGN KEY (hebergement_id) REFERENCES hebergement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE hebergement_user ADD CONSTRAINT FK_47E632D4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE informatique ADD CONSTRAINT FK_24CC943883DE392 FOREIGN KEY (camp_biblic_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE informatique_user ADD CONSTRAINT FK_1A98AD64CBC6B0B9 FOREIGN KEY (informatique_id) REFERENCES informatique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE informatique_user ADD CONSTRAINT FK_1A98AD64A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE logistic ADD CONSTRAINT FK_54BD53BD109FD92A FOREIGN KEY (cb_id) REFERENCES camp_biblique (id)');
        $this->addSql('ALTER TABLE montant ADD CONSTRAINT FK_A9F3E3288E46E9DE FOREIGN KEY (participator_id) REFERENCES participator (id)');
        $this->addSql('ALTER TABLE montant_camp_biblique ADD CONSTRAINT FK_DDD6357C1F8D148 FOREIGN KEY (montant_id) REFERENCES montant (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE montant_camp_biblique ADD CONSTRAINT FK_DDD6357C62CA15CB FOREIGN KEY (camp_biblique_id) REFERENCES camp_biblique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE paroisse ADD CONSTRAINT FK_9068949C53C9D7E5 FOREIGN KEY (doyenne_id) REFERENCES doyenne (id)');
        $this->addSql('ALTER TABLE paroisse ADD CONSTRAINT FK_9068949CDE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE participator ADD CONSTRAINT FK_BEE9AD38217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
        $this->addSql('ALTER TABLE participator_camp_biblique ADD CONSTRAINT FK_9DED40DE8E46E9DE FOREIGN KEY (participator_id) REFERENCES participator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participator_camp_biblique ADD CONSTRAINT FK_9DED40DE62CA15CB FOREIGN KEY (camp_biblique_id) REFERENCES camp_biblique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD17653C9D7E5 FOREIGN KEY (doyenne_id) REFERENCES doyenne (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176C40C2240 FOREIGN KEY (paroisse_id) REFERENCES paroisse (id)');
        $this->addSql('ALTER TABLE person ADD CONSTRAINT FK_34DCD176DE95C867 FOREIGN KEY (sector_id) REFERENCES sector (id)');
        $this->addSql('ALTER TABLE removal_camp_biblique ADD CONSTRAINT FK_CFD2709BA00B94E6 FOREIGN KEY (removal_id) REFERENCES removal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE removal_camp_biblique ADD CONSTRAINT FK_CFD2709B62CA15CB FOREIGN KEY (camp_biblique_id) REFERENCES camp_biblique (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE removal_participator ADD CONSTRAINT FK_C404113EA00B94E6 FOREIGN KEY (removal_id) REFERENCES removal (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE removal_participator ADD CONSTRAINT FK_C404113E8E46E9DE FOREIGN KEY (participator_id) REFERENCES participator (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649217BBB47 FOREIGN KEY (person_id) REFERENCES person (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administration DROP FOREIGN KEY FK_9FDD0D1883DE392');
        $this->addSql('ALTER TABLE administration_user DROP FOREIGN KEY FK_1C4927A39B8E743');
        $this->addSql('ALTER TABLE administration_user DROP FOREIGN KEY FK_1C4927AA76ED395');
        $this->addSql('ALTER TABLE cost DROP FOREIGN KEY FK_182694FC83DE392');
        $this->addSql('ALTER TABLE cost DROP FOREIGN KEY FK_182694FC1F8D148');
        $this->addSql('ALTER TABLE doyenne DROP FOREIGN KEY FK_67E2BA5CDE95C867');
        $this->addSql('ALTER TABLE finance DROP FOREIGN KEY FK_CE28EAE083DE392');
        $this->addSql('ALTER TABLE finance_user DROP FOREIGN KEY FK_22872D495E87A6C2');
        $this->addSql('ALTER TABLE finance_user DROP FOREIGN KEY FK_22872D49A76ED395');
        $this->addSql('ALTER TABLE hebergement DROP FOREIGN KEY FK_4852DD9C83DE392');
        $this->addSql('ALTER TABLE hebergement_user DROP FOREIGN KEY FK_47E632D423BB0F66');
        $this->addSql('ALTER TABLE hebergement_user DROP FOREIGN KEY FK_47E632D4A76ED395');
        $this->addSql('ALTER TABLE informatique DROP FOREIGN KEY FK_24CC943883DE392');
        $this->addSql('ALTER TABLE informatique_user DROP FOREIGN KEY FK_1A98AD64CBC6B0B9');
        $this->addSql('ALTER TABLE informatique_user DROP FOREIGN KEY FK_1A98AD64A76ED395');
        $this->addSql('ALTER TABLE logistic DROP FOREIGN KEY FK_54BD53BD109FD92A');
        $this->addSql('ALTER TABLE montant DROP FOREIGN KEY FK_A9F3E3288E46E9DE');
        $this->addSql('ALTER TABLE montant_camp_biblique DROP FOREIGN KEY FK_DDD6357C1F8D148');
        $this->addSql('ALTER TABLE montant_camp_biblique DROP FOREIGN KEY FK_DDD6357C62CA15CB');
        $this->addSql('ALTER TABLE paroisse DROP FOREIGN KEY FK_9068949C53C9D7E5');
        $this->addSql('ALTER TABLE paroisse DROP FOREIGN KEY FK_9068949CDE95C867');
        $this->addSql('ALTER TABLE participator DROP FOREIGN KEY FK_BEE9AD38217BBB47');
        $this->addSql('ALTER TABLE participator_camp_biblique DROP FOREIGN KEY FK_9DED40DE8E46E9DE');
        $this->addSql('ALTER TABLE participator_camp_biblique DROP FOREIGN KEY FK_9DED40DE62CA15CB');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD17653C9D7E5');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176C40C2240');
        $this->addSql('ALTER TABLE person DROP FOREIGN KEY FK_34DCD176DE95C867');
        $this->addSql('ALTER TABLE removal_camp_biblique DROP FOREIGN KEY FK_CFD2709BA00B94E6');
        $this->addSql('ALTER TABLE removal_camp_biblique DROP FOREIGN KEY FK_CFD2709B62CA15CB');
        $this->addSql('ALTER TABLE removal_participator DROP FOREIGN KEY FK_C404113EA00B94E6');
        $this->addSql('ALTER TABLE removal_participator DROP FOREIGN KEY FK_C404113E8E46E9DE');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649217BBB47');
        $this->addSql('DROP TABLE administration');
        $this->addSql('DROP TABLE administration_user');
        $this->addSql('DROP TABLE camp_biblique');
        $this->addSql('DROP TABLE cost');
        $this->addSql('DROP TABLE doyenne');
        $this->addSql('DROP TABLE finance');
        $this->addSql('DROP TABLE finance_user');
        $this->addSql('DROP TABLE hebergement');
        $this->addSql('DROP TABLE hebergement_user');
        $this->addSql('DROP TABLE informatique');
        $this->addSql('DROP TABLE informatique_user');
        $this->addSql('DROP TABLE logistic');
        $this->addSql('DROP TABLE montant');
        $this->addSql('DROP TABLE montant_camp_biblique');
        $this->addSql('DROP TABLE paroisse');
        $this->addSql('DROP TABLE participator');
        $this->addSql('DROP TABLE participator_camp_biblique');
        $this->addSql('DROP TABLE person');
        $this->addSql('DROP TABLE removal');
        $this->addSql('DROP TABLE removal_camp_biblique');
        $this->addSql('DROP TABLE removal_participator');
        $this->addSql('DROP TABLE sector');
        $this->addSql('DROP TABLE user');
    }
}
