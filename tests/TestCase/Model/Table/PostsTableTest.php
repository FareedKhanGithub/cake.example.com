<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PostsTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;
use Cake\Utility\Text;
/**
 * App\Model\Table\PostsTable Test Case
 */
class PostsTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\PostsTable
     */
    public $Posts;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Posts',
        //'app.Users'
        //'plugin.CakeDC/Users/Users'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Posts') ? [] : ['className' => PostsTable::class];
        $this->Posts = TableRegistry::getTableLocator()->get('Posts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Posts);
        parent::tearDown();
    }


    public function testCreateSlug()
    {
        $result = $this->Posts->createSlug('Hello World');
        $this->assertEquals('hello-world', $result);
        $result = $this->Posts->createSlug('Hello!, World');
        $this->assertEquals('hello-world', $result);
        $result = $this->Posts->createSlug('Hello   World*$');
        $this->assertEquals('hello-world', $result);
        $result = $this->Posts->createSlug('Hello-   World-');
        $this->assertEquals('hello-world', $result);
    }

    public function  testBeforeMarshal()
    {
        $article = $this->Posts->newEntity();
        $article = $this->Posts->patchEntity($article, [
            'title'=>'Hello World, It\'s a fine day',
            'user_id'=>Text::uuid()

        ]);
        $this->Posts->save($article);

        $result = $this->Posts
        ->find()
        ->where(['slug'=>'hello-world-it-s-a-fine-day'])
        ->first();
    $this->assertEquals('hello-world-it-s-a-fine-day', $result['slug']);}

}