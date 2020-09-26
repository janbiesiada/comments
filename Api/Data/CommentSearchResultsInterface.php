<?php
declare(strict_types=1);

namespace Jbdev\Comments\Api\Data;

interface CommentSearchResultsInterface
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
