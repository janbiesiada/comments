<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver\DataProvider;

use Jbdev\Comments\Api\CommentRepositoryInterface;
use Jbdev\Comments\Api\Data\CommentInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Reflection\DataObjectProcessor;

class Comment
{
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;
    /**
     * @var DataObjectProcessor
     */
    private $dataObjectProcessor;
    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;
    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @param CommentRepositoryInterface $commentRepository
     * @param DataObjectProcessor $dataObjectProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     */
    public function __construct(
        CommentRepositoryInterface $commentRepository,
        DataObjectProcessor $dataObjectProcessor,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder
    ) {
        $this->commentRepository = $commentRepository;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
    }

    /**
     * @param string $id
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function getData(string $id): array
    {
        $comment = $this->commentRepository->get($id);

        if (false === $comment->getCommentId()) {
            throw new NoSuchEntityException(
                __('The Comment block with the "%1" ID doesn\'t exist.', $id)
            );
        }
        return $this->buildArray($comment);
    }

    public function getTree(string $rootId = null, $rootType = null): array
    {
        $comments = [];
        $commentsById = [];
        $sortOrder = $this->sortOrderBuilder
            ->setDescendingDirection()
            ->setField(CommentInterface::LEVEL)
            ->create();
        foreach ($this->commentRepository->getList($this->searchCriteriaBuilder->addSortOrder($sortOrder)->create())->getItems() as $comment) {
            $comments[$comment->getLevel() . '-' . $comment->getParentType() . '-' . $comment->getParentId()][] = $this->buildArray($comment);
            $commentsById[$comment->getCommentId()] = $this->buildArray($comment);
            $commentsById[$comment->getCommentId()]['children'] = [];
        }
        $root = [];
        foreach ($comments as $identifier => $subComments) {
            $idArray = explode('-', $identifier);
            foreach ($subComments as $comment) {
                if ($idArray[1] == 'comment') {
                    $commentsById[$idArray[2]]['children'][$comment['comment_id']] = $commentsById[$comment['comment_id']];
                }
            }
        }
        foreach ($commentsById as $node) {
            if ($node['level'] == '1') {
                if ($rootId && $rootType && ($rootId != $node['parent_id'] || $rootType != $node['parent_type'])) {
                    continue;
                }
                $root[$node['comment_id']] = $node;
            }
        }
        return $root;
    }

    /**
     * @param CommentInterface $comment
     *
     * @return array
     *
     */
    protected function buildArray(CommentInterface $comment): array
    {
        $data = $this->dataObjectProcessor->buildOutputDataArray($comment, CommentInterface::class);
        $data['model'] = $comment;
        return $data;
    }
}
