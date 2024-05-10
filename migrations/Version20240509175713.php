<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240509175713 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_information (id INT AUTO_INCREMENT NOT NULL, number_of_guests INT NOT NULL, default_name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE allergy (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking (id INT AUTO_INCREMENT NOT NULL, number_of_guests INT NOT NULL, date DATE NOT NULL, name VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE booking_allergy (booking_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_910F07953301C60 (booking_id), INDEX IDX_910F0795DBFD579D (allergy_id), PRIMARY KEY(booking_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE catering_service (id INT AUTO_INCREMENT NOT NULL, number_of_guests INT DEFAULT NULL, date_open DATE NOT NULL, date_close DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE day (id INT AUTO_INCREMENT NOT NULL, active TINYINT(1) NOT NULL, open_am TIME NOT NULL, close_am TIME NOT NULL, open_pm TIME NOT NULL, close_pm TIME NOT NULL, name VARCHAR(50) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dishes (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, best_dishes TINYINT(1) NOT NULL, INDEX IDX_584DD35D12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE formula (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_category (menu_id INT NOT NULL, category_id INT NOT NULL, INDEX IDX_2A1D5C57CCD7E912 (menu_id), INDEX IDX_2A1D5C5712469DE2 (category_id), PRIMARY KEY(menu_id, category_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_formula (menu_id INT NOT NULL, formula_id INT NOT NULL, INDEX IDX_EFEA453FCCD7E912 (menu_id), INDEX IDX_EFEA453FA50A6386 (formula_id), PRIMARY KEY(menu_id, formula_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE number_of_place (id INT AUTO_INCREMENT NOT NULL, number_of_place INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture_dishes (id INT AUTO_INCREMENT NOT NULL, dishes_id INT DEFAULT NULL, title VARCHAR(100) NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_C9A9654DA05DD37A (dishes_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, additional_information_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D64969818E1C (additional_information_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE booking_allergy ADD CONSTRAINT FK_910F07953301C60 FOREIGN KEY (booking_id) REFERENCES booking (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE booking_allergy ADD CONSTRAINT FK_910F0795DBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dishes ADD CONSTRAINT FK_584DD35D12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C57CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C5712469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FCCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE menu_formula ADD CONSTRAINT FK_EFEA453FA50A6386 FOREIGN KEY (formula_id) REFERENCES formula (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture_dishes ADD CONSTRAINT FK_C9A9654DA05DD37A FOREIGN KEY (dishes_id) REFERENCES dishes (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64969818E1C FOREIGN KEY (additional_information_id) REFERENCES additional_information (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking_allergy DROP FOREIGN KEY FK_910F07953301C60');
        $this->addSql('ALTER TABLE booking_allergy DROP FOREIGN KEY FK_910F0795DBFD579D');
        $this->addSql('ALTER TABLE dishes DROP FOREIGN KEY FK_584DD35D12469DE2');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C57CCD7E912');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C5712469DE2');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FCCD7E912');
        $this->addSql('ALTER TABLE menu_formula DROP FOREIGN KEY FK_EFEA453FA50A6386');
        $this->addSql('ALTER TABLE picture_dishes DROP FOREIGN KEY FK_C9A9654DA05DD37A');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64969818E1C');
        $this->addSql('DROP TABLE additional_information');
        $this->addSql('DROP TABLE allergy');
        $this->addSql('DROP TABLE booking');
        $this->addSql('DROP TABLE booking_allergy');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE catering_service');
        $this->addSql('DROP TABLE day');
        $this->addSql('DROP TABLE dishes');
        $this->addSql('DROP TABLE formula');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_category');
        $this->addSql('DROP TABLE menu_formula');
        $this->addSql('DROP TABLE number_of_place');
        $this->addSql('DROP TABLE picture_dishes');
        $this->addSql('DROP TABLE user');
    }
}
