<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241113085548 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY paiements_ibfk_2');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY paiements_ibfk_1');
        $this->addSql('DROP INDEX Usersid ON paiements');
        $this->addSql('DROP INDEX Voituresid ON paiements');
        $this->addSql('ALTER TABLE paiements ADD user_id INT NOT NULL, ADD voiture_id INT NOT NULL, ADD methode_paiement VARCHAR(255) NOT NULL, ADD statut VARCHAR(50) NOT NULL, ADD numeroCarteBleu VARCHAR(16) NOT NULL, DROP MethodePaiements, DROP statue, DROP NumCarte, DROP Usersid, DROP Voituresid, CHANGE montant montant NUMERIC(10, 2) NOT NULL');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E12A76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT FK_E1B02E12181A8BA FOREIGN KEY (voiture_id) REFERENCES voitures (id)');
        $this->addSql('CREATE INDEX IDX_E1B02E12A76ED395 ON paiements (user_id)');
        $this->addSql('CREATE INDEX IDX_E1B02E12181A8BA ON paiements (voiture_id)');
        $this->addSql('ALTER TABLE users ADD creation_date DATE NOT NULL, ADD last_login DATE DEFAULT NULL, DROP creationDate, DROP lastLogin, CHANGE name name VARCHAR(255) NOT NULL, CHANGE password password VARCHAR(255) NOT NULL, CHANGE email email VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E12A76ED395');
        $this->addSql('ALTER TABLE paiements DROP FOREIGN KEY FK_E1B02E12181A8BA');
        $this->addSql('DROP INDEX IDX_E1B02E12A76ED395 ON paiements');
        $this->addSql('DROP INDEX IDX_E1B02E12181A8BA ON paiements');
        $this->addSql('ALTER TABLE paiements ADD MethodePaiements VARCHAR(255) DEFAULT NULL, ADD statue VARCHAR(50) DEFAULT NULL, ADD NumCarte VARCHAR(20) DEFAULT NULL, ADD Usersid INT DEFAULT NULL, ADD Voituresid INT DEFAULT NULL, DROP user_id, DROP voiture_id, DROP methode_paiement, DROP statut, DROP numeroCarteBleu, CHANGE montant montant NUMERIC(10, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT paiements_ibfk_2 FOREIGN KEY (Voituresid) REFERENCES voitures (id)');
        $this->addSql('ALTER TABLE paiements ADD CONSTRAINT paiements_ibfk_1 FOREIGN KEY (Usersid) REFERENCES users (id)');
        $this->addSql('CREATE INDEX Usersid ON paiements (Usersid)');
        $this->addSql('CREATE INDEX Voituresid ON paiements (Voituresid)');
        $this->addSql('ALTER TABLE users ADD lastLogin DATE DEFAULT NULL, DROP creation_date, CHANGE name name VARCHAR(255) DEFAULT NULL, CHANGE password password VARCHAR(255) DEFAULT NULL, CHANGE email email VARCHAR(255) DEFAULT NULL, CHANGE last_login creationDate DATE DEFAULT NULL');
    }
}
