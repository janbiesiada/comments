<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model;

use Jbdev\Comments\Api\Data\CommentInterface;
use Magento\Framework\Model\AbstractModel;

class Comment extends AbstractModel implements CommentInterface
{
    public function getCommentId(): string
    {
        return $this->getData(self::COMMENT_ID);
    }

    public function getUserName(): string
    {
        return $this->getData(self::USER_NAME);
    }

    public function getParentType(): string
    {
        return $this->getData(self::PARENT_TYPE);
    }

    public function getParentId(): string
    {
        return $this->getData(self::PARENT_ID);
    }

    public function getLevel(): string
    {
        return $this->getData(self::LEVEL);
    }

    public function getContent(): string
    {
        return $this->getData(self::CONTENT);
    }

    public function getCreatedAt(): string
    {
        return $this->getData(self::CREATED_AT);
    }

    public function getUpdatedAt(): string
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setCommentId(string $commentId): CommentInterface
    {
        return $this->setData(self::COMMENT_ID, $commentId);
    }

    public function setUserName(string $userName): CommentInterface
    {
        return $this->setData(self::USER_NAME, $userName);
    }

    public function setParentType(string $parentType): CommentInterface
    {
        return $this->setData(self::PARENT_TYPE, $parentType);
    }

    public function setParentId(string $parentId): CommentInterface
    {
        return $this->setData(self::PARENT_ID, $parentId);
    }

    public function setLevel(string $level): CommentInterface
    {
        return $this->setData(self::LEVEL, $level);
    }

    public function setContent(string $content): CommentInterface
    {
        return $this->setData(self::CONTENT, $content);
    }

    public function setCreatedAt(string $createdAt): CommentInterface
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function setUpdatedAt(string $updatedAt): CommentInterface
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
