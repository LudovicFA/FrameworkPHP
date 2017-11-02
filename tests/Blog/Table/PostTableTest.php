<?php

namespace Tests\App\Blog\Table;

use Tests\DatabaseTestCase;
use PHPUnit\Framework\TestCase;
use App\Blog\Table\PostTable;
use App\Blog\Entity\Post;

/**
 *
 */
class PostTableTest extends DatabaseTestCase
{
  private $postTable;

  public function setUp()
  {
    parent::setUp();
    $this->postTable = new PostTable($this->pdo);
  }
  public function testFind()
  {
    $this->seedDatabase();
    $post = $this->postTable->find(1);
    $this->assertInstanceOf(Post::class, $post);
  }

  public function testFindNotFoundRecord()
  {
      $post = $this->postTable->find(10000);
      $this->assertNull($post);
  }


  public function testUpdate()
  {
      $this->seedDatabase();
    $this->postTable->update(1,['name' => 'Salut', 'slug' => 'demo']);
    $post = $this->postTable->find(1);
    $this->assertEquals('Salut', $post->name);
    $this->assertEquals('demo', $post->slug);
  }

  public function testInsert()
  {
    $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo']);
    $post = $this->postTable->find(1);
    $this->assertEquals('Salut', $post->name);
    $this->assertEquals('demo', $post->slug);
  }

  public function testDelete()
  {
    $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo']);
    $this->postTable->insert(['name' => 'Salut', 'slug' => 'demo']);
    $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
    $this->assertEquals(2, (int) $count);
    $this->postTable->delete($this->pdo->lastInsertId());
    $count = $this->pdo->query('SELECT COUNT(id) FROM posts')->fetchColumn();
    $this->assertEquals(1, (int) $count);
  }
}
