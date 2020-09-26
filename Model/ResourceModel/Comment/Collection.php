<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\ResourceModel\Comment;

use Jbdev\Comments\Model\Comment as Model;
use Jbdev\Comments\Model\ResourceModel\Comment as ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init(
            Model::class,
            ResourceModel::class
        );
    }
}
