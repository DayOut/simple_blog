<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Comment;
use AppBundle\Entity\Post;
use AppBundle\Type\CommentType;
use AppBundle\Type\PostType;
use Doctrine\ORM\EntityManager;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class PostController extends Controller
{
    /**
     * @Route("/post/{id}", name="post")
     *
     * @param Post $post
     * @param Request $request
     *
     * @return Response
     */
    public function indexAction(Post $post, Request $request)
    {
        $comment = new Comment();
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
		//--------------------------------------------------------------------------------
            $comment->setPost($post);//собственно тут и подвязываю номер поста к комменту
		//--------------------------------------------------------------------------------
            $em->persist($comment);
            $em->flush();

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        //Вывод постов по дате
        $post_id = $post->getId();

        $query = $em->createQueryBuilder() // формируем запрос
        ->from('AppBundle:Comment', 'c')
            ->select('c')
            ->where('c.post = :post_id')
            ->setParameter('post_id', $post_id)
            ->orderBy('c.date', 'DESC')
            ->getQuery();

        /** @var Comment[] $products */
        $comments = $query->execute();
        //--------------------

        return $this->render('Post/index.html.twig', [
            'post' => $post,
            'form' => $form->createView(),
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("form/{id}", name="post_form")
     */
    public function formAction($id=null, Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine')->getManager();

        if($id == null)
        {
            $post = new Post();
        }
        else
        {
            $post = $em->find(Post::class, $id);
            if(!$post)
            {
                throw new NotFoundHttpException();
            }
        }

        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($post);
            $em->flush();

            return $this->redirectToRoute('post', ['id' => $post->getId()]);
        }

        return $this->render('default/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}