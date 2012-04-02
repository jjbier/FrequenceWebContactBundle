<?php

namespace FrequenceWeb\Bundle\ContactBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    public function testIndex()
    {
        /** @var $client \Symfony\Bundle\FrameworkBundle\Client */
        $client = static::createClient();
        /** @var $crawler \Symfony\Component\DomCrawler\Crawler  */
        $crawler = $client->request('GET', '/contact.html');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());

        $form = $crawler->selectButton('contact_message_submit')->form();
        $form->setValues(array(
            'contact[name]'    => 'John Doe',
            'contact[subject]' => 'I have a message for you.',
            'contact[body]'    => 'This is my message body.',
        ));
        $client->submit($form);

        $this->assertNotInstanceOf('Symfony\\Component\\HttpFoundation\\RedirectResponse', $client->getResponse());

        $form = $crawler->selectButton('contact_message_submit')->form();
        $form->setValues(array(
            'contact[name]'    => 'John Doe',
            'contact[email]'   => 'john.doe@gmail.com',
            'contact[subject]' => 'I have a message for you.',
            'contact[body]'    => 'This is my message body.',
        ));
        $client->submit($form);

        $this->assertInstanceOf('Symfony\\Component\\HttpFoundation\\RedirectResponse', $client->getResponse());
        $client->followRedirect();
    }
}
