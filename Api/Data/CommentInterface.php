<?php
declare(strict_types=1);

namespace Jbdev\Comments\Api\Data;

interface CommentInterface
{
    public const COMMENT_ID = "comment_id";
    public const USER_NAME = "user_name";
    public const PARENT_TYPE = "parent_type";
    public const PARENT_ID = "parent_id";
    public const LEVEL = "level";
    public const CONTENT = "content";
    public const CREATED_AT = "created_at";
    public const UPDATED_AT = "updated_at";

    /**
     * @return string
     */
    public function getCommentId(): string;
    /**
 * @return string
 */

    public function getUserName(): string;
    /**
     * @return string
     */
    public function getParentType(): string;
    /**
     * @return string
     */
    public function getParentId(): string;
    /**
     * @return string
     */
    public function getLevel(): string;
    /**
     * @return string
     */
    public function getContent(): string;
    /**
     * @return string
     */
    public function getCreatedAt(): string;
    /**
     * @return string
     */
    public function getUpdatedAt(): string;

    /**
     * @param string $commentId
     *
     * @return CommentInterface
     */
    public function setCommentId(string $commentId): CommentInterface;

    /**
     * @param string $userName
     *
     * @return CommentInterface
     */
    public function setUserName(string $userName): CommentInterface;

    /**
     * @param string $parentType
     *
     * @return CommentInterface
     */
    public function setParentType(string $parentType): CommentInterface;

    /**
     * @param string $parentId
     *
     * @return CommentInterface
     */
    public function setParentId(string $parentId): CommentInterface;

    /**
     * @param string $level
     *
     * @return CommentInterface
     */
    public function setLevel(string $level): CommentInterface;

    /**
     * @param string $content
     *
     * @return CommentInterface
     */
    public function setContent(string $content): CommentInterface;

    /**
     * @param string $createdAt
     *
     * @return CommentInterface
     */
    public function setCreatedAt(string $createdAt): CommentInterface;

    /**
     * @param string $updatedAt
     *
     * @return CommentInterface
     */
    public function setUpdatedAt(string $updatedAt): CommentInterface;

}
