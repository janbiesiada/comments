<?php

namespace Jbdev\Comments\Tests\Unit\Model;

use Jbdev\Comments\Model\Comment;
use Jbdev\Comments\Model\CommentRepository;
use Jbdev\Comments\Model\CommentFactory;
use Jbdev\Comments\Model\CommentSearchResults;
use Jbdev\Comments\Model\CommentSearchResultsFactory;
use Jbdev\Comments\Model\ResourceModel\Comment as CommentResourceModel;
use Jbdev\Comments\Model\ResourceModel\Comment\Collection;
use Jbdev\Comments\Model\ResourceModel\Comment\CollectionFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
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
    /**
     * @var CommentSearchResults
     */
    private $commentSearchResults;
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteria;
    /**
     * @var Collection
     */
    private $commentCollection;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CommentSearchResultsFactory
     */
    private $commentSearchResultsFactory;

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
        $this->collectionFactory = $this->getMockBuilder(CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->commentCollection = $this->getMockBuilder(Collection::class)
            ->disableOriginalConstructor()
            ->setMethods(['getItems','getSize'])
            ->getMock();
        $collectionProcessor = $this->getMockBuilder(CollectionProcessorInterface::class)
            ->disableOriginalConstructor()
            ->setMethods(['process'])
            ->getMock();
        $this->commentSearchResultsFactory = $this->getMockBuilder(CommentSearchResultsFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();
        $this->commentSearchResults = $this->getMockBuilder(CommentSearchResults::class)
            ->disableOriginalConstructor()
            ->setMethods(['setSearchCriteria','setItems','setTotalCount'])
            ->getMock();
        $this->searchCriteria = $this->getMockBuilder(SearchCriteriaInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->repository = $objectManager->getObject(CommentRepository::class, [
            'resource' => $this->resource,
            'commentFactory' => $this->commentFactory,
            'commentCollectionFactory' => $this->collectionFactory,
            'collectionProcessor' => $collectionProcessor,
            'commentSearchResultsFactory' => $this->commentSearchResultsFactory,
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
    public function testSaveException()
    {
        $this->resource->expects($this->any())
            ->method('save')
            ->with($this->model)
            ->willThrowException(new \Exception('test'));
        $this->resource->expects($this->any())
            ->method('getIdFieldName')
            ->willReturn('comment_id');

        $this->expectException(CouldNotSaveException::class);
        $this->repository->save($this->model);
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
    public function testGetException()
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
            ->willReturn('');

        $this->expectException(NoSuchEntityException::class);
        $this->repository->get(1);
    }

    public function testGetList()
    {
        $this->collectionFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->commentCollection);
        $this->commentSearchResults->expects($this->any())->method('setSearchCriteria');
        $this->commentSearchResults->expects($this->any())->method('setItems');
        $this->commentSearchResults->expects($this->any())->method('setTotalCount');
        $this->commentSearchResultsFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->commentSearchResults);
        $this->commentCollection->expects($this->any())
            ->method('getItems')
            ->willReturn([]);
        $this->commentCollection->expects($this->any())
            ->method('getSize')
            ->willReturn(0);
        $this->assertEquals($this->commentSearchResults, $this->repository->getList($this->searchCriteria));
    }
}
