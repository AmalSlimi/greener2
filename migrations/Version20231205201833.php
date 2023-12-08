<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205201833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (ref INT NOT NULL, author_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, publication_date DATE NOT NULL, published TINYINT(1) NOT NULL, category VARCHAR(255) NOT NULL, INDEX IDX_CBE5A331F675F31B (author_id), PRIMARY KEY(ref)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('DROP TABLE livraison');
        $this->addSql('DROP TABLE produit_consomme_energie');
        $this->addSql('DROP TABLE produit_energie');
        $this->addSql('DROP TABLE produit_vehicule');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE reponse');
        $this->addSql('DROP TABLE transport');
        $this->addSql('DROP TABLE type_energie');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_Commande_Panier');
        $this->addSql('ALTER TABLE commande CHANGE date_commande date_commande DATE NOT NULL, CHANGE adresse_livraison adresse_livraison VARCHAR(500) NOT NULL, CHANGE date_livraison date_livraison DATE NOT NULL, CHANGE mode_paiement mode_paiement VARCHAR(500) NOT NULL, CHANGE panierId panierid INT NOT NULL');
        $this->addSql('DROP INDEX fk_commande_panier ON commande');
        $this->addSql('CREATE INDEX IDX_6EEAA67DE702BC1E ON commande (panierid)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_Commande_Panier FOREIGN KEY (panierId) REFERENCES panier (panierId)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4D1AA708F FOREIGN KEY (id_post) REFERENCES post (id_post)');
        $this->addSql('DROP INDEX fk_commentaires_post ON commentaires');
        $this->addSql('CREATE INDEX IDX_D9BEC0C4D1AA708F ON commentaires (id_post)');
        $this->addSql('ALTER TABLE entreprise CHANGE id id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('DROP INDEX UNIQUE_client_id ON panier');
        $this->addSql('ALTER TABLE panier CHANGE clientId clientid INT NOT NULL, CHANGE produitId produitid INT NOT NULL, CHANGE quantite quantite INT NOT NULL, CHANGE prix prix DOUBLE PRECISION NOT NULL, CHANGE total total DOUBLE PRECISION NOT NULL, CHANGE Nomproduit nomproduit VARCHAR(255) NOT NULL');
        $this->addSql('DROP INDEX selector ON reset_password_request');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id id INT AUTO_INCREMENT NOT NULL, CHANGE requested_at requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE expires_at expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
        $this->addSql('DROP INDEX fk_7ce748aa76ed395 ON reset_password_request');
        $this->addSql('CREATE INDEX IDX_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('DROP INDEX user_id_idx ON user');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE livraison (livraison_id INT AUTO_INCREMENT NOT NULL, commande_id INT NOT NULL, coursier_id INT NOT NULL, date_livraison DATE NOT NULL, statut_livraison VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse_livraison VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX commande_id (commande_id), PRIMARY KEY(livraison_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit_consomme_energie (id_pr_cons_en INT AUTO_INCREMENT NOT NULL, id_produit INT NOT NULL, id_energie INT NOT NULL, consommation_mentuelle INT NOT NULL, PRIMARY KEY(id_pr_cons_en)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit_energie (produit_id INT NOT NULL, energie_id INT NOT NULL, INDEX IDX_E47C51D9F347EFB (produit_id), INDEX IDX_E47C51D9B732A364 (energie_id), PRIMARY KEY(produit_id, energie_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE produit_vehicule (produit_id INT NOT NULL, vehicule_id INT NOT NULL, INDEX IDX_30CD0EF347EFB (produit_id), INDEX IDX_30CD0E4A4A3511 (vehicule_id), PRIMARY KEY(produit_id, vehicule_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reclamation (idReclamation INT AUTO_INCREMENT NOT NULL, nom VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, email VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci` COMMENT \'il faut sairi @\', screenshot VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numero_mobile VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_creation DATE NOT NULL, date_traitement DATE NOT NULL, nomServcie VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idReclamation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reponse (idReponse INT AUTO_INCREMENT NOT NULL, Text VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, status VARCHAR(256) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, idReclamation INT DEFAULT NULL, INDEX idReclamation (idReclamation), PRIMARY KEY(idReponse)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE transport (id_produit INT AUTO_INCREMENT NOT NULL, id_véhicule INT NOT NULL, distance_tot DOUBLE PRECISION NOT NULL, id_transport INT NOT NULL, PRIMARY KEY(id_produit)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE type_energie (id INT AUTO_INCREMENT NOT NULL, libellet VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, pollution_par_kwh INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DE702BC1E');
        $this->addSql('ALTER TABLE commande CHANGE panierid panierId INT DEFAULT NULL, CHANGE date_commande date_commande DATE DEFAULT NULL, CHANGE adresse_livraison adresse_livraison VARCHAR(255) DEFAULT NULL, CHANGE date_livraison date_livraison DATE DEFAULT NULL, CHANGE mode_paiement mode_paiement VARCHAR(50) DEFAULT NULL');
        $this->addSql('DROP INDEX idx_6eeaa67de702bc1e ON commande');
        $this->addSql('CREATE INDEX FK_Commande_Panier ON commande (panierId)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DE702BC1E FOREIGN KEY (panierid) REFERENCES panier (panierid)');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4D1AA708F');
        $this->addSql('ALTER TABLE commentaires DROP FOREIGN KEY FK_D9BEC0C4D1AA708F');
        $this->addSql('DROP INDEX idx_d9bec0c4d1aa708f ON commentaires');
        $this->addSql('CREATE INDEX fk_commentaires_post ON commentaires (id_post)');
        $this->addSql('ALTER TABLE commentaires ADD CONSTRAINT FK_D9BEC0C4D1AA708F FOREIGN KEY (id_post) REFERENCES post (id_post)');
        $this->addSql('ALTER TABLE entreprise CHANGE id id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement_user DROP FOREIGN KEY FK_2EC0B3C4FD02F13');
        $this->addSql('ALTER TABLE evenement_user DROP FOREIGN KEY FK_2EC0B3C4A76ED395');
        $this->addSql('ALTER TABLE panier CHANGE clientid clientId INT DEFAULT NULL, CHANGE produitid produitId INT DEFAULT NULL, CHANGE quantite quantite INT DEFAULT NULL, CHANGE prix prix DOUBLE PRECISION DEFAULT NULL, CHANGE total total DOUBLE PRECISION DEFAULT NULL, CHANGE nomproduit Nomproduit VARCHAR(255) DEFAULT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQUE_client_id ON panier (clientId)');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE reset_password_request CHANGE id id INT NOT NULL, CHANGE requested_at requested_at DATETIME NOT NULL, CHANGE expires_at expires_at DATETIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX selector ON reset_password_request (selector)');
        $this->addSql('DROP INDEX idx_7ce748aa76ed395 ON reset_password_request');
        $this->addSql('CREATE INDEX FK_7CE748AA76ED395 ON reset_password_request (user_id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP INDEX primary, ADD INDEX user_id_idx (id)');
    }
}
