<?php

namespace App\Test\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PostControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private PostRepository $repository;
    private string $path = '/post/';
    private EntityManagerInterface $manager;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Post::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Post index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'post[idEntreprise]' => 'Testing',
            'post[titre]' => 'Testing',
            'post[typedecontenu]' => 'Testing',
            'post[contenu]' => 'Testing',
            'post[date]' => 'Testing',
            'post[image]' => 'Testing',
        ]);

        self::assertResponseRedirects('/post/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Post();
        $fixture->setIdEntreprise('My Title');
        $fixture->setTitre('My Title');
        $fixture->setTypedecontenu('My Title');
        $fixture->setContenu('My Title');
        $fixture->setDate('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Post');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Post();
        $fixture->setIdEntreprise('My Title');
        $fixture->setTitre('My Title');
        $fixture->setTypedecontenu('My Title');
        $fixture->setContenu('My Title');
        $fixture->setDate('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'post[idEntreprise]' => 'Something New',
            'post[titre]' => 'Something New',
            'post[typedecontenu]' => 'Something New',
            'post[contenu]' => 'Something New',
            'post[date]' => 'Something New',
            'post[image]' => 'Something New',
        ]);

        self::assertResponseRedirects('/post/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getIdEntreprise());
        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getTypedecontenu());
        self::assertSame('Something New', $fixture[0]->getContenu());
        self::assertSame('Something New', $fixture[0]->getDate());
        self::assertSame('Something New', $fixture[0]->getImage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Post();
        $fixture->setIdEntreprise('My Title');
        $fixture->setTitre('My Title');
        $fixture->setTypedecontenu('My Title');
        $fixture->setContenu('My Title');
        $fixture->setDate('My Title');
        $fixture->setImage('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/post/');
    }
}
