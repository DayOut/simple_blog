<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Post;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\ORM\EntityManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        /** @var Registry $doctrine */
        $doctrine = $this->get('doctrine'); // указатель на доктрину

        /** @var EntityManager $manager */
        $manager = $doctrine->getManager(); // указатель на доступ к менеджеру (для работы с бд)

        $query = $manager->createQueryBuilder() // формируем запрос
            ->from('AppBundle:Post', 'p')
            ->select('p')
            ->orderBy('p.publicationDate', 'DESC')
            ->setMaxResults(3)
            ->getQuery();

        /** @var Post[] $products */
        $posts = $query->execute();

        return $this->render('default/index.html.twig', [
            'posts' => $posts,
        ]);
    }


}
