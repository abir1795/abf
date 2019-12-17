<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191212210726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE bon_livrsn (id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, address VARCHAR(255) NOT NULL, total_doc NUMERIC(10, 2) NOT NULL, date_creation DATETIME NOT NULL, client_id INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bonlivrsn_line (id INT AUTO_INCREMENT NOT NULL, bon_livrsn_id INT DEFAULT NULL, produit_id INT NOT NULL, produit_nom VARCHAR(255) NOT NULL, qty INT NOT NULL, prix NUMERIC(10, 2) NOT NULL, INDEX IDX_EB7512A5318A3CE3 (bon_livrsn_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bonlivrsn_line ADD CONSTRAINT FK_EB7512A5318A3CE3 FOREIGN KEY (bon_livrsn_id) REFERENCES bon_livrsn (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE bonlivrsn_line DROP FOREIGN KEY FK_EB7512A5318A3CE3');
        $this->addSql('DROP TABLE bon_livrsn');
        $this->addSql('DROP TABLE bonlivrsn_line');
    }
}
