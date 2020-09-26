<?php
declare(strict_types=1);

namespace Jbdev\Comments\Api;

use Jbdev\Comments\Api\Data\CommentInterface;
use Jbdev\Comments\Api\Data\CommentSearchResultsInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;

interface CommentRepositoryInterface
{
    /**
     * @param CommentInterface $comment
     *
     * @return CommentInterface
     *
     * @throws CouldNotSaveException
     */
    public function save(CommentInterface $comment): CommentInterface;

    /**
     * @param string $commentId
     *
     * @return CommentInterface
     *
     * @throws NoSuchEntityException
     */
    public function get(string $commentId): CommentInterface;

    public function getList(SearchCriteriaInterface $searchCriteria): CommentSearchResultsInterface;
}
