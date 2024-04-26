<?php

namespace App\Test\Controller;

use App\Entity\Pagina;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PaginaControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/pagina/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Pagina::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pagina index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'pagina[titulo]' => 'Testing',
            'pagina[subtitulo]' => 'Testing',
            'pagina[texto]' => 'Testing',
            'pagina[galeria]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pagina();
        $fixture->setTitulo('My Title');
        $fixture->setSubtitulo('My Title');
        $fixture->setTexto('My Title');
        $fixture->setGaleria('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Pagina');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pagina();
        $fixture->setTitulo('Value');
        $fixture->setSubtitulo('Value');
        $fixture->setTexto('Value');
        $fixture->setGaleria('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'pagina[titulo]' => 'Something New',
            'pagina[subtitulo]' => 'Something New',
            'pagina[texto]' => 'Something New',
            'pagina[galeria]' => 'Something New',
        ]);

        self::assertResponseRedirects('/pagina/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitulo());
        self::assertSame('Something New', $fixture[0]->getSubtitulo());
        self::assertSame('Something New', $fixture[0]->getTexto());
        self::assertSame('Something New', $fixture[0]->getGaleria());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Pagina();
        $fixture->setTitulo('Value');
        $fixture->setSubtitulo('Value');
        $fixture->setTexto('Value');
        $fixture->setGaleria('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/pagina/');
        self::assertSame(0, $this->repository->count([]));
    }
}
