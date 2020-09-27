<?php
declare(strict_types=1);

namespace Jbdev\Comments\Model\Resolver;

use Jbdev\Comments\Api\CommentRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;

class UpdateComment implements ResolverInterface
{
    /**
     * @var CommentRepositoryInterface
     */
    private $commentRepository;

    public function __construct(
        CommentRepositoryInterface $commentRepository
    ) {
        $this->commentRepository = $commentRepository;
    }

    public function resolve(Field $field, $context, ResolveInfo $info, array $value = null, array $args = null)
    {
        $input = $args['input'];
        if (empty($input['comment_id'])) {
            return false;
        }
        try {
            $comment = $this->commentRepository->get($input['comment_id']);
        } catch (NoSuchEntityException $e) {
            return false;
        }
        $comment->setData($input);
        $this->commentRepository->save($comment);
        return true;
    }
}
