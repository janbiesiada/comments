<?php
declare(strict_types=1);

namespace Jbdev\Comments\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface CommentSearchResultsInterface extends SearchResultsInterface
{
    /**
     * @return CommentInterface[]
     */
    public function getItems();

    /**
     * @param CommentInterface[] $items
     *
     * @return $this
     */
    public function setItems(array $items);

}
