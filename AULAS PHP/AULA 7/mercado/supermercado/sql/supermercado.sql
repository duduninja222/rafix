CREATE DATABASE IF NOT EXISTS supermercado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE supermercado;
SET NAMES utf8mb4;
DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS categorias;
CREATE TABLE categorias (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(60) NOT NULL UNIQUE,
  descricao VARCHAR(255) NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
CREATE TABLE produtos (
  id INT AUTO_INCREMENT PRIMARY KEY,
  codigo VARCHAR(30) NOT NULL UNIQUE,
  nome VARCHAR(120) NOT NULL,
  descricao TEXT NULL,
  categoria_id INT NOT NULL,
  preco DECIMAL(10,2) NOT NULL CHECK (preco > 0),
  estoque INT NOT NULL DEFAULT 0 CHECK (estoque >= 0),
  estoque_minimo INT NOT NULL DEFAULT 0 CHECK (estoque_minimo >= 0),
  validade DATE NULL,
  CONSTRAINT fk_produto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id)
    ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO categorias (nome, descricao) VALUES
('Mercearia','Alimentos não perecíveis'),
('Laticínios','Leites, queijos e iogurtes'),
('Bebidas','Sucos, refrigerantes e águas'),
('Limpeza','Produtos de limpeza doméstica');

INSERT INTO produtos (codigo,nome,descricao,categoria_id,preco,estoque,estoque_minimo,validade) VALUES
('001234','Arroz Tipo 1 5kg','Arroz branco',1,27.90,40,10,'2027-06-30'),
('7890001','Feijão Carioca 1kg',NULL,1,8.49,25,10,'2027-03-15'),
('7890002','Macarrão Espaguete 500g',NULL,1,4.99,0,8,'2027-08-01'),
('7890003','Leite Integral 1L','Caixa UHT',2,5.79,6,12,'2027-01-20'),
('7890004','Queijo Mussarela 500g','Fatiado',2,24.90,15,5,'2026-10-01'),
('7890005','Iogurte Natural 170g',NULL,2,2.89,30,10,'2026-12-20'),
('7890006','Suco de Laranja 1L',NULL,3,7.50,18,6,'2027-02-10'),
('7890007','Refrigerante Cola 2L',NULL,3,9.99,50,15,NULL),
('7890008','Detergente Líquido 500ml',NULL,4,2.79,60,20,NULL),
('7890009','Água Sanitária 2L',NULL,4,6.49,12,12,NULL);
