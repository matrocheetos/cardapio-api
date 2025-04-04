<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250404191350 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            CREATE TABLE categoria (id_categoria INT AUTO_INCREMENT NOT NULL, descricao VARCHAR(255) NOT NULL, PRIMARY KEY(id_categoria)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE mesa (comanda INT AUTO_INCREMENT NOT NULL, nro_mesa INT NOT NULL, status_pagamento TINYINT(1) DEFAULT 0 NOT NULL, PRIMARY KEY(comanda)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE pedido (id_pedido INT AUTO_INCREMENT NOT NULL, comanda INT NOT NULL, id_produto INT NOT NULL, observacao VARCHAR(255) DEFAULT NULL, data_pedido DATETIME NOT NULL, status_pedido VARCHAR(10) NOT NULL, INDEX IDX_C4EC16CE45C50E54 (comanda), INDEX IDX_C4EC16CE8231E0A7 (id_produto), PRIMARY KEY(id_pedido)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            CREATE TABLE produto (id_produto INT AUTO_INCREMENT NOT NULL, id_categoria INT NOT NULL, nome VARCHAR(255) NOT NULL, descricao VARCHAR(255) NOT NULL, imagem VARCHAR(255) DEFAULT NULL, preco DOUBLE PRECISION NOT NULL, eh_vegano TINYINT(1) DEFAULT 0 NOT NULL, eh_sem_gluten TINYINT(1) DEFAULT 0 NOT NULL, porcoes INT NOT NULL, INDEX IDX_5CAC49D7CE25AE0A (id_categoria), PRIMARY KEY(id_produto)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE45C50E54 FOREIGN KEY (comanda) REFERENCES mesa (comanda) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pedido ADD CONSTRAINT FK_C4EC16CE8231E0A7 FOREIGN KEY (id_produto) REFERENCES produto (id_produto) ON DELETE CASCADE
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produto ADD CONSTRAINT FK_5CAC49D7CE25AE0A FOREIGN KEY (id_categoria) REFERENCES categoria (id_categoria) ON DELETE CASCADE
        SQL);
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql(<<<'SQL'
            ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE45C50E54
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE pedido DROP FOREIGN KEY FK_C4EC16CE8231E0A7
        SQL);
        $this->addSql(<<<'SQL'
            ALTER TABLE produto DROP FOREIGN KEY FK_5CAC49D7CE25AE0A
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE categoria
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE mesa
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE pedido
        SQL);
        $this->addSql(<<<'SQL'
            DROP TABLE produto
        SQL);
    }
}
