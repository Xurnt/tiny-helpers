<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Doctrine\ORM\EntityManagerInterface;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;



class FrontController extends AbstractController
{
    /**
     * @Route("/", name="front")
     */
    public function index(EntityManagerInterface $em)
    {
        $articleRepo = $em->getRepository(Article::class);
        $articles=$articleRepo->findAll();
        $categoryRepo = $em->getRepository(Category::class);
        $categories=$categoryRepo->findAll();
        $userRepo = $em->getRepository(User::class);
        $users=$userRepo->findAll();
        return $this->render('front/index.html.twig', [
            'controller_name' => 'FrontController',
            "articles"=>$articles,
            "categories"=>$categories,
            "users"=>$users
        ]);
    }
}
