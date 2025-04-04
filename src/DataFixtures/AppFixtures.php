<?php

namespace App\DataFixtures;

use App\Entity\Categoria;
use App\Entity\Produto;
use App\Entity\Mesa;
use App\Entity\Pedido;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // criar Categorias
        $bebidas = new Categoria();
        $bebidas->setDescricao('Bebidas');
        $manager->persist($bebidas);

        $comidas = new Categoria();
        $comidas->setDescricao('Comidas');
        $manager->persist($comidas);

        // criar Produtos
        $coca = new Produto();
        $coca->setNome('Coca-Cola')
            ->setDescricao('Refrigerante de cola 350ml')
            ->setImagem('https://santoeliasdoces.com.br/wp-content/uploads/2021/07/coca-zero-lata-350-400x400.jpg')
            ->setPreco(6.00)
            ->setEhVegano(true)
            ->setEhSemGluten(true)
            ->setPorcoes(1)
            ->setCategoria($bebidas);
        $manager->persist($coca);

        $suco = new Produto();
        $suco->setNome('Suco de Laranja Natural')
            ->setDescricao('Suco de laranja natural sem açúcar')
            ->setImagem('https://www.supermercadoriodaspedras.com.br/wp-content/uploads/2022/09/0000005043934.jpg')
            ->setPreco(8.00)
            ->setEhVegano(true)
            ->setEhSemGluten(true)
            ->setPorcoes(1)
            ->setCategoria($bebidas);
        $manager->persist($suco);

        $hamburguer = new Produto();
        $hamburguer->setNome('Hambúrguer Clássico')
            ->setDescricao('Pão, carne, queijo e salada')
            ->setImagem('https://instadelivery-public.nyc3.cdn.digitaloceanspaces.com/itens/1712003808660b1ae0ae54a_75_75.jpeg')
            ->setPreco(18.90)
            ->setEhVegano(false)
            ->setEhSemGluten(false)
            ->setPorcoes(1)
            ->setCategoria($comidas);
        $manager->persist($hamburguer);

        $strogonoff = new Produto();
        $strogonoff->setNome('Strogonoff de Frango')
            ->setDescricao('Acompanha arroz branco e batata palha')
            ->setImagem('https://receitasnotadez.com.br/wp-content/uploads/2019/12/strogonoff-de-frango-1548843823-300x300.jpg')
            ->setPreco(20.00)
            ->setEhVegano(false)
            ->setEhSemGluten(true)
            ->setPorcoes(1)
            ->setCategoria($comidas);
        $manager->persist($strogonoff);

        $lasanha = new Produto();
        $lasanha->setNome('Lasanha de Legumes')
            ->setDescricao('Lasanha vegetariana com legumes grelhados')
            ->setImagem('https://bo.cozinharsemstress.pt/cozinhar/wp-content/uploads/2018/01/A1-4861176-site.jpg')
            ->setPreco(18.90)
            ->setEhVegano(true)
            ->setEhSemGluten(false)
            ->setPorcoes(1)
            ->setCategoria($comidas);
        $manager->persist($lasanha);

        // criar Mesas
        $mesa1 = new Mesa();
        $mesa1->setNroMesa(10)->setStatusPagamento(false);
        $manager->persist($mesa1);

        $mesa2 = new Mesa();
        $mesa2->setNroMesa(11)->setStatusPagamento(true);
        $manager->persist($mesa2);

        // criar Pedidos
        $pedido1 = new Pedido($mesa1, $coca, 'Com gelo');
        $pedido1->setMesa($mesa1)
                ->setProduto($coca)
                ->setStatusPedido('PREPARANDO');
        $manager->persist($pedido1);

        $pedido2 = new Pedido($mesa2, $hamburguer, 'Bem passado');
        $pedido2->setMesa($mesa2)
                ->setProduto($hamburguer)
                ->setStatusPedido('ENTREGUE');
        $manager->persist($pedido2);

        // salvar todos
        $manager->flush();
    }
}
