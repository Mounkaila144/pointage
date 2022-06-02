<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220601150728 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, UNIQUE INDEX UNIQ_880E0D76E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE autorisation (id INT AUTO_INCREMENT NOT NULL, emploiyee_id INT NOT NULL, date DATETIME NOT NULL, status INT NOT NULL, INDEX IDX_9A43134E398F566 (emploiyee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `employee` (id INT AUTO_INCREMENT NOT NULL, groupe_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(50) NOT NULL, naissance DATE DEFAULT NULL, UNIQUE INDEX UNIQ_5D9F75A1E7927C74 (email), INDEX IDX_5D9F75A17A45358C (groupe_id), FULLTEXT INDEX `employee` (nom, prenom, email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE group_employer (id INT AUTO_INCREMENT NOT NULL, nombre INT NOT NULL, tache VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, message LONGTEXT NOT NULL, type VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_employee (notification_id INT NOT NULL, employee_id INT NOT NULL, INDEX IDX_88F4D04EF1A9D84 (notification_id), INDEX IDX_88F4D048C03F15C (employee_id), PRIMARY KEY(notification_id, employee_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE notification_group_employer (notification_id INT NOT NULL, group_employer_id INT NOT NULL, INDEX IDX_359274C7EF1A9D84 (notification_id), INDEX IDX_359274C7647581BB (group_employer_id), PRIMARY KEY(notification_id, group_employer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE societe (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, localisation VARCHAR(255) NOT NULL, duree_pause VARCHAR(50) NOT NULL, nombre_emloyee INT NOT NULL, heure_debut_travail TIME NOT NULL, heure_fin_travail TIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE autorisation ADD CONSTRAINT FK_9A43134E398F566 FOREIGN KEY (emploiyee_id) REFERENCES `employee` (id)');
        $this->addSql('ALTER TABLE `employee` ADD CONSTRAINT FK_5D9F75A17A45358C FOREIGN KEY (groupe_id) REFERENCES group_employer (id)');
        $this->addSql('ALTER TABLE notification_employee ADD CONSTRAINT FK_88F4D04EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_employee ADD CONSTRAINT FK_88F4D048C03F15C FOREIGN KEY (employee_id) REFERENCES `employee` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_group_employer ADD CONSTRAINT FK_359274C7EF1A9D84 FOREIGN KEY (notification_id) REFERENCES notification (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE notification_group_employer ADD CONSTRAINT FK_359274C7647581BB FOREIGN KEY (group_employer_id) REFERENCES group_employer (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE autorisation DROP FOREIGN KEY FK_9A43134E398F566');
        $this->addSql('ALTER TABLE notification_employee DROP FOREIGN KEY FK_88F4D048C03F15C');
        $this->addSql('ALTER TABLE `employee` DROP FOREIGN KEY FK_5D9F75A17A45358C');
        $this->addSql('ALTER TABLE notification_group_employer DROP FOREIGN KEY FK_359274C7647581BB');
        $this->addSql('ALTER TABLE notification_employee DROP FOREIGN KEY FK_88F4D04EF1A9D84');
        $this->addSql('ALTER TABLE notification_group_employer DROP FOREIGN KEY FK_359274C7EF1A9D84');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE autorisation');
        $this->addSql('DROP TABLE `employee`');
        $this->addSql('DROP TABLE group_employer');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE notification_employee');
        $this->addSql('DROP TABLE notification_group_employer');
        $this->addSql('DROP TABLE societe');
    }
}
