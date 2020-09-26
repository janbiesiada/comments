<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Comment extends AbstractDb
{
    /**
     * @return void
     */
    protected function _construct():void
    {
        $this->_init('jbdev_comment', 'comment_id');
    }
}
