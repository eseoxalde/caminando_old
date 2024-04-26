<?php

namespace App\Test\Controller;

use App\Entity\Sitio;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SitioControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/main/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Sitio::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sitio index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'sitio[header]' => 'Testing',
            'sitio[menu]' => 'Testing',
            'sitio[contenido]' => 'Testing',
            'sitio[footer]' => 'Testing',
            'sitio[content]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sitio();
        $fixture->setHeader('My Title');
        $fixture->setMenu('My Title');
        $fixture->setContenido('My Title');
        $fixture->setFooter('My Title');
        $fixture->setContent('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Sitio');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sitio();
        $fixture->setHeader('Value');
        $fixture->setMenu('Value');
        $fixture->setContenido('Value');
        $fixture->setFooter('Value');
        $fixture->setContent('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sitio[header]' => 'Something New',
            'sitio[menu]' => 'Something New',
            'sitio[contenido]' => 'Something New',
            'sitio[footer]' => 'Something New',
            'sitio[content]' => 'Something New',
        ]);

        self::assertResponseRedirects('/main/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getHeader());
        self::assertSame('Something New', $fixture[0]->getMenu());
        self::assertSame('Something New', $fixture[0]->getContenido());
        self::assertSame('Something New', $fixture[0]->getFooter());
        self::assertSame('Something New', $fixture[0]->getContent());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Sitio();
        $fixture->setHeader('Value');
        $fixture->setMenu('Value');
        $fixture->setContenido('Value');
        $fixture->setFooter('Value');
        $fixture->setContent('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/main/');
        self::assertSame(0, $this->repository->count([]));
    }
}
