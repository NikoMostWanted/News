<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/05/16
 * Time: 17:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Form\Comments;
use AppBundle\Entity\Form\News;
use AppBundle\Form\CommentsForm;
use AppBundle\Form\NewsPublisherForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class NewsController extends Controller
{

    /**
     * @Route("/news/publish/{_locale}", name="Publish", requirements={"_locale" = "en|ru|ua"})
     * @Template("AppBundle:News:publish-news.html.twig")
     */
    public function actionPublishNews(Request $request)
    {
        $news_form = new News();
        $form = $this->createForm(new NewsPublisherForm(), $news_form);
        $form->handleRequest($request);

        if ($form->isValid()) {

            $news_db = new \AppBundle\Entity\News();
            $news_db->setTitle($news_form->getTitle());
            $news_db->setText($news_form->getText());

            $em = $this->getDoctrine()->getManager();
            $em->persist($news_db);
            $em->flush();
            return $this->render('AppBundle:News:publish-news-success.html.twig', array('id' => $news_db->getId()));
        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/news/show/{_locale}", name="Show", requirements={"_locale" = "en|ru|ua"})
     * @Template("AppBundle:News:show-news.html.twig")
     */
    public function actionShowNews(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $dql = "SELECT a FROM AppBundle:News a";
        $query = $em->createQuery($dql);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        return array('pagination' => $pagination);
    }

    /**
     * @Route("/news/more/{_locale}/{id}", name="MoreInfo", requirements={"_locale" = "en|ru|ua"})
     * @Template("AppBundle:News:more-info.html.twig")
     */
    public function actionMoreInfo($id, Request $request)
    {
        $news = $this->getDoctrine()->getRepository("AppBundle:News")
            ->find($id);

        $em = $this->getDoctrine()->getManager();
        $query = $em->createQuery(
            'SELECT p
    FROM AppBundle:Comments p
    WHERE p.idNews = :id'
        )->setParameter('id', $id);

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            10
        );

        $comments = new Comments();
        $form = $this->createForm(new CommentsForm(), $comments);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $comments_db = new \AppBundle\Entity\Comments();
            $comments_db->setText($comments->getText());
            $comments_db->setName($comments->getName());
            $comments_db->setIdNews($id);
            $em = $this->getDoctrine()->getManager();
            $em->persist($comments_db);
            $em->flush();
            return $this->render('AppBundle:News:comments-success.html.twig');
        }

        return array('news' => $news, 'comments' => $pagination, 'form' => $form->createView());
    }
}