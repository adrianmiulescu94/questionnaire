<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240830105923 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answers DROP FOREIGN KEY FK_50D0C6061E2C3794');
        $this->addSql('DROP INDEX UNIQ_50D0C6061E2C3794 ON answers');
        $this->addSql('ALTER TABLE answers DROP display_restricted_question_id');
        $this->addSql('ALTER TABLE questions ADD category_id INT NOT NULL, ADD restricted_by_answer_id INT DEFAULT NULL, DROP is_restricted');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D512469DE2 FOREIGN KEY (category_id) REFERENCES categories (id)');
        $this->addSql('ALTER TABLE questions ADD CONSTRAINT FK_8ADC54D5F544E837 FOREIGN KEY (restricted_by_answer_id) REFERENCES answers (id)');
        $this->addSql('CREATE INDEX IDX_8ADC54D512469DE2 ON questions (category_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8ADC54D5F544E837 ON questions (restricted_by_answer_id)');
        $this->addSql('ALTER TABLE questions ADD `order` INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D512469DE2');
        $this->addSql('ALTER TABLE questions DROP FOREIGN KEY FK_8ADC54D5F544E837');
        $this->addSql('DROP INDEX IDX_8ADC54D512469DE2 ON questions');
        $this->addSql('DROP INDEX UNIQ_8ADC54D5F544E837 ON questions');
        $this->addSql('ALTER TABLE questions ADD is_restricted TINYINT(1) NOT NULL, DROP category_id, DROP restricted_by_answer_id');
        $this->addSql('ALTER TABLE answers ADD display_restricted_question_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE answers ADD CONSTRAINT FK_50D0C6061E2C3794 FOREIGN KEY (display_restricted_question_id) REFERENCES questions (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_50D0C6061E2C3794 ON answers (display_restricted_question_id)');
        $this->addSql('ALTER TABLE questions DROP `order`');
    }
}
