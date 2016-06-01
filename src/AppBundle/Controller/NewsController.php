<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/05/16
 * Time: 17:15
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Form\News;
use AppBundle\Form\NewsPublisherForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class NewsController extends Controller
{

    /**
     *@Route("/news/publish/{_locale}", name="Publish", requirements={"_locale" = "en|ru|ua"})
     *@Template("AppBundle:News:publish-news.html.twig")
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
            $translated = $this->get('translator')->trans('Publish new news with id');
            return new Response('<i>'.$translated.' '.$news_db->getId().'</i>');

        }

        return array('form' => $form->createView());
    }

    /**
     * @Route("/news/show/{_locale}", name="Show", requirements={"_locale" = "en|ru|ua"})
     * @Template("AppBundle:News:show-news.html.twig")
     */
    public function actionShowNews()
    {
        $news = $this->getDoctrine()
            ->getRepository("AppBundle:News")
            ->findAll();

        if (!$news) {
            return new Response('<i>Not Found</i>');
        }

        return array("news" => $news);
    }
}