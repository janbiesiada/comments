<?php

namespace Jbdev\Comments\Model;

use Jbdev\Comments\Model\ResourceModel\Comment as CommentResourceModel;
use Jbdev\Comments\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Jbdev\Comments\Model\CommentFactory;
use Jbdev\Comments\Model\CommentSearchResultsFactor;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{
    /**
     * @var CommentRepository
     */
    private $repository;
    /**
     * @var Comment
     */
    private $model;
    /**
     * @var CommentResourceModel
     */
    private $resource;
    /**
     * @var CommentFactory
     */
    private $commentFactory;

    protected function setUp()
    {
        $objectManager = new ObjectManager($this);
        $this->resource = $this->getMockBuilder(CommentResourceModel::class)
            ->disableOriginalConstructor()
            ->setMethods(['save','getIdFieldName'])
            ->getMock();
        $this->commentFactory = $this->getMockBuilder(CommentFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $commentCollectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->getMock();
        $collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
        $commentSearchResultsFactory = $this->getMockBuilder(CommentSearchResultsFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $objectManager->getObject(CommentRepository::class, [
            'resource' => $this->resource,
            'commentFactory' => $this->commentFactory,
            'commentCollectionFactory' => $commentCollectionFactory,
            'collectionProcessor' => $collectionProcessor,
            'commentSearchResultsFactory' => $commentSearchResultsFactory,
        ]);
        $this->model = $this->getMockBuilder(Comment::class)
            ->disableOriginalConstructor()
            ->setMethods(['load','getCommentId'])
            ->getMock();
    }


    public function testSave()
    {
        $this->resource->expects($this->any())
            ->method('save')
            ->with($this->model)
            ->willReturn($this->resource);
        $this->resource->expects($this->any())
            ->method('getIdFieldName')
            ->willReturn('comment_id');

        $this->assertEquals($this->model, $this->repository->save($this->model));
    }

    public function testGet()
    {
        $this->commentFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->model);
        $this->model->expects($this->any())
            ->method('load')
            ->with('1')
            ->willReturn($this->model);
        $this->model->expects($this->any())
            ->method('getCommentId')
            ->willReturn(1);

        $this->assertEquals($this->model, $this->repository->get(1));
        $this->assertEquals(1, $this->repository->get(1)->getCommentId());
    }

    public function testGetList()
    {
    }

}
