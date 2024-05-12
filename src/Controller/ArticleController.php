<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Author;
use App\Entity\User;
use App\Form\NewArticleType;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ArticleController extends AbstractController
{
    private EntityManagerInterface $em;
    private $articleRepository;
    public function __construct(ArticleRepository $articleRepository, EntityManagerInterface $em)
    {
        $this->articleRepository = $articleRepository;
        $this->em = $em;
    }

    #[Route('/article/new', name: 'app_article_new')]
    public function newArticle(Request $request): Response
    {
        $article = new Article();
        $form = $this->createForm(NewArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $newArticle = $form->getData();



            $this->em->persist($newArticle);
            $this->em->flush();

            return $this->redirectToRoute('app_homepage');

        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/article/edit/{id}', name: 'app_edit_article')]
    public function edit($id, Request $request): Response
    {
        $article = $this->articleRepository->find($id);
        $form = $this->createForm(NewArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $article->setTitle($form->get('title')->getData());
            $article->setContent($form->get('content')->getData());

            $this->em->flush();
            return $this->redirectToRoute('app_articles_user');
        }

        return $this->render('article/edit.html.twig', [
            'article' => $article,
            'form' => $form->createView()
        ]);
    }

    #[Route('/articles/user', name:'app_articles_user')]
    public function userArticles(): Response
    {
        $user = $this->getUser();
        $userId = $user->getId();

        $articles = $this->articleRepository->findBy(['author' => $userId]);




        return $this->render('article/post.html.twig', [
            'articles' => $articles
        ]);
    }

    #[Route('/articles/user/{id}', name: 'show_article_user', methods: ['GET'])]
    public function userArticle($id): Response
    {
        $article = $this->articleRepository->find($id);


        return $this->render('article/user_post.html.twig', [
            'article' => $article
        ]);
    }

    #[Route('/article/delete/{id}', name: 'app_delete_article', methods: ['GET', 'DELETE'])]
    public function delete($id): Response
    {
        $article = $this->articleRepository->find($id);
        $this->em->remove($article);

        $this->em->flush();
        return $this->redirectToRoute('app_articles_user');

    }
}
