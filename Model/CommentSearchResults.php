<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model;

use Jbdev\Comments\Api\Data\CommentSearchResultsInterface;
use Magento\Framework\Api\SearchResults;

class CommentSearchResults extends SearchResults implements CommentSearchResultsInterface
{
}
