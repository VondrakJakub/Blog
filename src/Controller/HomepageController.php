<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomepageController extends AbstractController
{
    private $articleRepository;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    #[Route('/articles/{id}', name: 'show_article', methods: ['GET'])]
    public function show($id): Response
    {
        $article = $this->articleRepository->find($id);


        return $this->render('article/index.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/homepage', name: 'app_homepage')]
    public function index(): Response
    {
        $articles = $this->articleRepository->findAll();

        return $this->render('homepage/index.html.twig', [
            'articles' => $articles
        ]);
    }
}
