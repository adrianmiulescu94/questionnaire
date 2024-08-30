<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830132422 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE responses (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE response_answer (response_id INT NOT NULL, answer_id INT NOT NULL, INDEX IDX_B1A66D0AFBF32840 (response_id), INDEX IDX_B1A66D0AAA334807 (answer_id), PRIMARY KEY(response_id, answer_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE response_answer ADD CONSTRAINT FK_B1A66D0AFBF32840 FOREIGN KEY (response_id) REFERENCES responses (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE response_answer ADD CONSTRAINT FK_B1A66D0AAA334807 FOREIGN KEY (answer_id) REFERENCES answers (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE response_answer DROP FOREIGN KEY FK_B1A66D0AFBF32840');
        $this->addSql('ALTER TABLE response_answer DROP FOREIGN KEY FK_B1A66D0AAA334807');
        $this->addSql('DROP TABLE responses');
        $this->addSql('DROP TABLE response_answer');
    }
}
