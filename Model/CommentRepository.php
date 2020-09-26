<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model;

use Exception;
use Jbdev\Comments\Api\CommentRepositoryInterface;
use Jbdev\Comments\Api\Data\CommentInterface;
use Jbdev\Comments\Api\Data\CommentSearchResultsInterface;
use Jbdev\Comments\Model\ResourceModel\Comment as CommentResourceModel;
use Jbdev\Comments\Model\ResourceModel\Comment\CollectionFactory;
use Jbdev\Comments\Model\ResourceModel\Comment\Collection;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

class CommentRepository implements CommentRepositoryInterface
{

    /**
     * @var ResourceModel\Comment
     */
    private $resource;
    /**
     * @var CommentFactory
     */
    private $commentFactory;
    /**
     * @var CollectionFactory
     */
    private $commentCollectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var CommentSearchResultsFactory
     */
    private $commentSearchResultsFactory;

    public function __construct(
        CommentResourceModel $resource,
        CommentFactory $commentFactory,
        CollectionFactory $commentCollectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        CommentSearchResultsFactory $commentSearchResultsFactory
    ) {
        $this->resource = $resource;
        $this->commentFactory = $commentFactory;
        $this->commentCollectionFactory = $commentCollectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->commentSearchResultsFactory = $commentSearchResultsFactory;
    }

    public function save(CommentInterface $comment): CommentInterface
    {
        try {
            $this->resource->save($comment);
        } catch (Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the comment: %1', $exception->getMessage()),
                $exception
            );
        }
        return $comment;
    }

    public function get(string $commentId): CommentInterface
    {
        /** @var Comment $comment */
        $comment = $this->commentFactory->create();
        $comment->load($commentId);
        if (!$comment->getCommentId()) {
            throw new NoSuchEntityException(__('The comment with the "%1" ID doesn\'t exist.', $commentId));
        }
        return $comment;
    }

    public function getList(SearchCriteriaInterface $searchCriteria): CommentSearchResultsInterface
    {
        /** @var Collection $collection */
        $collection = $this->commentCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var CommentSearchResultsInterface $searchResults */
        $searchResults = $this->commentSearchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }
}
