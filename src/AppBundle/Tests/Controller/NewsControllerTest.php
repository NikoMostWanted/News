<?php
/**
 * Created by PhpStorm.
 * User: niko
 * Date: 25/05/16
 * Time: 20:19
 */

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class News extends WebTestCase
{
    public function testShowGet()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/news/show');
        $this->assertTrue($crawler->filter('body')->count() >= 0);
    }

    public function testShowPost()
    {
        $client = static::createClient();
        $crawler = $client->request('POST','/news/show');
        $this->assertTrue($crawler->filter('body')->count() >= 0);
    }

    public function testPublishClickButtonNormal()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/news/publish');
        $form = $crawler->selectButton('NewsPublisher[Publish]')->form();
        $form['NewsPublisher[title]'] = 'Good news';
        $form['NewsPublisher[text]'] = 'It is very important news!';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('i')->count() >= 0);
    }

    public function testPublishClickButtonEmptyText()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/news/publish');
        $form = $crawler->selectButton('NewsPublisher[Publish]')->form();
        $form['NewsPublisher[title]'] = 'Title';
        $form['NewsPublisher[text]'] = '';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('li')->count() > 0);
    }

    public function testPublishClickButtonEmptyTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/news/publish');
        $form = $crawler->selectButton('NewsPublisher[Publish]')->form();
        $form['NewsPublisher[title]'] = '';
        $form['NewsPublisher[text]'] = 'Good News';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('li')->count() > 0);
    }

    public function testPublishClickButtonCrowdedTitle()
    {
        $client = static::createClient();
        $crawler = $client->request('GET','/news/publish');
        $form = $crawler->selectButton('NewsPublisher[Publish]')->form();
        $form['NewsPublisher[title]'] = 'Yeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
        $form['NewsPublisher[text]'] = 'Good News';
        $crawler = $client->submit($form);
        $this->assertTrue($crawler->filter('li')->count() > 0);
    }
}