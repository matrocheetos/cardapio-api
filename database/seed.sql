INSERT INTO RESTAURANTE (ID_RESTAURANTE, NOME, LOGO, COR_PRIM_1, COR_PRIM_2, COR_PRIM_3) 
VALUES (1, 'Meu Restaurante', 'logo.png', '#FF5733', '#C70039', '#900C3F');

INSERT INTO CATEGORIA (DESCRICAO) VALUES 
('Entradas'),
('Pratos Principais'),
('Sobremesas'),
('Bebidas');

INSERT INTO PRODUTO (NOME, DESCRICAO, IMAGEM, PRECO, EH_VEGANO, EH_SEM_GLUTEN, PORCOES, CATEGORIA) VALUES 
('Salada Caesar', 'Salada com molho especial e croutons', 'https://www.listchallenges.com/f/items/879490b9-0427-48b0-a54d-1e3b485a6766.jpg', 25.90, 0, 0, 1, 1), 
('Risoto de Cogumelos', 'Risoto cremoso de cogumelos frescos', 'https://www.epa.com.br/wp-content/uploads/2019/05/risoto.png', 42.50, 1, 1, 1, 2), 
('Bolo de Chocolate', 'Bolo feito com cacau 70%', 'https://static.wixstatic.com/media/d33eeb_41493a5a23fa4b5b87122adccce4658d~mv2.png/v1/crop/x_388,y_0,w_961,h_960/fill/w_198,h_198,al_c,q_85,usm_0.66_1.00_0.01,enc_auto/Bolo%20de%20Brigadeiro%20Belga.png',   18.00, 0, 1, 1, 3), 
('Suco de Laranja', 'Suco natural de laranja', 'https://www.mundoboaforma.com.br/wp-content/uploads/2018/06/suco-de-laranja-capa.jpg', 10.00, 1, 1, 1, 4);

INSERT INTO MESA (NRO_MESA, STATUS_PAGAMENTO) VALUES 
(1, 0),
(2, 1);

INSERT INTO PEDIDO (COMANDA, ID_PRODUTO, OBSERVACAO, STATUS_PEDIDO) VALUES 
(1, 1, NULL, 'PREPARANDO'),
(1, 2, NULL, 'PRONTO'),
(2, 4, 'Sem gelo', 'ENTREGUE');
