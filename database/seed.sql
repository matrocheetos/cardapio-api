INSERT INTO PRODUTO (NOME, DESCRICAO, IMAGEM, PRECO, EH_VEGANO, EH_SEM_GLUTEN, PORCOES, CATEGORIA) VALUES
('Salada Caesar', 'Salada com alface, croutons e molho especial', 'salada_caesar.jpg', 25.90, 0, 0, 2, 1),
('Risoto de Cogumelos', 'Risoto cremoso com mix de cogumelos', 'risoto_cogumelos.jpg', 39.90, 1, 1, 2, 2),
('Pizza Margherita', 'Pizza clássica com molho de tomate, muçarela e manjericão', 'pizza_margherita.jpg', 49.90, 0, 0, 4, 3);

INSERT INTO MESA (ID_MESA, COMANDA, PEDIDO) VALUES
(1, 1001, 'Pizza Margherita, Suco de Laranja'),
(2, 1002, 'Risoto de Cogumelos, Água com Gás'),
(3, 1003, 'Salada Caesar, Chá Gelado');
