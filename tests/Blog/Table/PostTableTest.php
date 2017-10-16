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

}
