<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240518171141 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64969818E1C');
        $this->addSql('CREATE TABLE user_allergy (user_id INT NOT NULL, allergy_id INT NOT NULL, INDEX IDX_93BC5CBFA76ED395 (user_id), INDEX IDX_93BC5CBFDBFD579D (allergy_id), PRIMARY KEY(user_id, allergy_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_allergy ADD CONSTRAINT FK_93BC5CBFA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_allergy ADD CONSTRAINT FK_93BC5CBFDBFD579D FOREIGN KEY (allergy_id) REFERENCES allergy (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE additional_information');
        $this->addSql('DROP INDEX UNIQ_8D93D64969818E1C ON user');
        $this->addSql('ALTER TABLE user ADD number_of_guests INT NOT NULL, ADD default_name VARCHAR(100) NOT NULL, DROP additional_information_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE additional_information (id INT AUTO_INCREMENT NOT NULL, number_of_guests INT NOT NULL, default_name VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE user_allergy DROP FOREIGN KEY FK_93BC5CBFA76ED395');
        $this->addSql('ALTER TABLE user_allergy DROP FOREIGN KEY FK_93BC5CBFDBFD579D');
        $this->addSql('DROP TABLE user_allergy');
        $this->addSql('ALTER TABLE user ADD additional_information_id INT DEFAULT NULL, DROP number_of_guests, DROP default_name');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64969818E1C FOREIGN KEY (additional_information_id) REFERENCES additional_information (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D64969818E1C ON user (additional_information_id)');
    }
}
