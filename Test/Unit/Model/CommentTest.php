<?php

namespace Jbdev\Comments\Test\Unit\Model;

use Jbdev\Comments\Model\Comment;
use Jbdev\Comments\Model\ResourceModel\Comment as ResourceModel;
use Jbdev\Comments\Model\ResourceModel\Comment\Collection;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;

class CommentTest extends TestCase
{
    /**
     * @var Comment
     */
    private $model;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $context = $this->getMockBuilder(Context::class)
            ->disableOriginalConstructor()
            ->getMock();
        $registry = $this->getMockBuilder(Registry::class)
            ->disableOriginalConstructor()
            ->getMock();
        $resource = $this->getMockBuilder(ResourceModel::class)
            ->disableOriginalConstructor()
            ->setMethods(['getIdFieldName'])
            ->getMock();
        $resource->expects($this->any())
            ->method('getIdFieldName')
            ->willReturn('comment_id');
        $resourceCollection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->getMock();
        $testData = [
            "comment_id" => '1',
            "user_name" => 'mr nobody',
            "parent_type" => 'product',
            "parent_id" => '1',
            "level" => '1',
            "content" => 'Test comment',
            "created_at" => '2020-09-26',
            "updated_at" => '2020-09-26',
        ];
        $this->model = $objectManager->getObject(Comment::class, [
            'context' => $context,
            'registry' => $registry,
            'resource' => $resource,
            'resourceCollection' => $resourceCollection,
            'data' => $testData
        ]);
    }

    public function testGetCommentId()
    {
        $this->assertEquals('1', $this->model->getCommentId());
    }

    public function testSetCommentId()
    {
        $this->assertEquals($this->model, $this->model->setCommentId('7'));
        $this->assertEquals('7', $this->model->getCommentId());
    }

    public function testGetUserName()
    {
        $this->assertEquals('mr nobody', $this->model->getUserName());
    }

    public function testSetUserName()
    {
        $this->assertEquals($this->model, $this->model->setUserName('test_data'));
        $this->assertEquals('test_data', $this->model->getUserName());
    }

    public function testGetParentType()
    {
        $this->assertEquals('product', $this->model->getParentType());
    }

    public function testSetParentType()
    {
        $this->assertEquals($this->model, $this->model->setParentType('category'));
        $this->assertEquals('category', $this->model->getParentType());
    }

    public function testGetParentId()
    {
        $this->assertEquals('1', $this->model->getParentId());
    }

    public function testSetParentId()
    {
        $this->assertEquals($this->model, $this->model->setParentId('2'));
        $this->assertEquals('2', $this->model->getParentId());
    }
    public function testGetLevel()
    {
        $this->assertEquals('1', $this->model->getLevel());
    }

    public function testSetLevel()
    {
        $this->assertEquals($this->model, $this->model->setLevel('2'));
        $this->assertEquals('2', $this->model->getLevel());
    }

    public function testGetContent()
    {
        $this->assertEquals('Test comment', $this->model->getContent());
    }

    public function testSetContent()
    {
        $this->assertEquals($this->model, $this->model->setContent('new content'));
        $this->assertEquals('new content', $this->model->getContent());
    }

    public function testGetCreatedAt()
    {
        $this->assertEquals('2020-09-26', $this->model->getCreatedAt());
    }

    public function testSetCreatedAt()
    {
        $this->assertEquals($this->model, $this->model->setCreatedAt('2020-09-28'));
        $this->assertEquals('2020-09-28', $this->model->getCreatedAt());
    }

    public function testGetUpdatedAt()
    {
        $this->assertEquals('2020-09-26', $this->model->getUpdatedAt());
    }

    public function testSetUpdatedAt()
    {
        $this->assertEquals($this->model, $this->model->setUpdatedAt('2020-09-27'));
        $this->assertEquals('2020-09-27', $this->model->getUpdatedAt());
    }
}
