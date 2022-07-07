<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220519130230 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD physical_address VARCHAR(255) DEFAULT NULL, ADD year_of_creation VARCHAR(255) DEFAULT NULL, ADD number_of_employees VARCHAR(255) DEFAULT NULL, ADD range_of_yearly_revenues VARCHAR(255) DEFAULT NULL, ADD type_of_company VARCHAR(255) DEFAULT NULL, ADD phase_of_the_company VARCHAR(255) DEFAULT NULL, ADD registration_number VARCHAR(255) DEFAULT NULL, ADD contact_person VARCHAR(255) DEFAULT NULL, ADD short_company_description LONGTEXT DEFAULT NULL, ADD interests VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP physical_address, DROP year_of_creation, DROP number_of_employees, DROP range_of_yearly_revenues, DROP type_of_company, DROP phase_of_the_company, DROP registration_number, DROP contact_person, DROP short_company_description, DROP interests');
    }
}
