<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231123035656 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement ADD id INT AUTO_INCREMENT NOT NULL, DROP id_evenement, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B26681EA4AEAFEA ON evenement (entreprise_id)');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE evenement_user ADD CONSTRAINT FK_2EC0B3C4A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EA4AEAFEA');
        $this->addSql('DROP INDEX IDX_B26681EA4AEAFEA ON evenement');
        $this->addSql('DROP INDEX `primary` ON evenement');
        $this->addSql('ALTER TABLE evenement ADD id_evenement INT NOT NULL, DROP id');
        $this->addSql('ALTER TABLE evenement_user DROP FOREIGN KEY FK_2EC0B3C4FD02F13');
        $this->addSql('ALTER TABLE evenement_user DROP FOREIGN KEY FK_2EC0B3C4A76ED395');
    }
}
