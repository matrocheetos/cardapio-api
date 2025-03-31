INSERT INTO RESTAURANTE (ID_RESTAURANTE, NOME, LOGO, COR_PRIM_1, COR_PRIM_2, COR_PRIM_3) 
VALUES (1, 'Meu Restaurante', 'logo.png', '#FF5733', '#C70039', '#900C3F');

INSERT INTO CATEGORIA (DESCRICAO) VALUES 
('Entradas'),
('Pratos Principais'),
('Sobremesas'),
('Bebidas');

INSERT INTO PRODUTO (NOME, DESCRICAO, IMAGEM, PRECO, EH_VEGANO, EH_SEM_GLUTEN, PORCOES, CATEGORIA) VALUES 
('Salada Caesar',       'Salada com molho especial e croutons', 'salada.jpg', 25.90, 0, 0, 1, 1), 
('Risoto de Cogumelos', 'Risoto cremoso de cogumelos frescos',  'risoto.jpg', 42.50, 1, 1, 1, 2), 
('Bolo de Chocolate',   'Bolo feito com cacau 70%',             'bolo.jpg',   18.00, 0, 1, 1, 3), 
('Suco de Laranja',     'Suco natural de laranja',              'suco.jpg',   10.00, 1, 1, 1, 4);

INSERT INTO MESA (NRO_MESA, STATUS_PAGAMENTO) VALUES 
(1, 0),
(2, 1);

INSERT INTO PEDIDO (COMANDA, ID_PRODUTO, OBSERVACAO, STATUS_PEDIDO) VALUES 
(1, 1, NULL, 'PREPARANDO'),
(1, 2, NULL, 'PRONTO'),
(2, 4, 'Sem gelo', 'ENTREGUE');
